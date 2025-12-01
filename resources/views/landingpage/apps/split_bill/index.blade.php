@extends('layout_landingpage.apps')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/landing/css/apps/splitify.css') }}" rel="stylesheet">
@endsection

@section('content')


    <section class="page-title centred pt_75">
        <div class="auto-container">
            <div class="content-box">
                <h1>Split Bill - HIMATIF Apps</h1>
            </div>
        </div>
    </section>
    <section class="sign-section pt_110 pb_120">
        <div class="pattern-layer" style="background-image: url(../assets/images/shape/shape-25.png);"></div>
        <div class="auto-container">
            <div class="form-inner">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    Aplikasi Split Bill
                </h1>
                <div class="input-group">
                    <label for="totalBill">Total Tagihan (IDR):</label>
                    <input type="text" id="totalBill" placeholder="Masukkan total tagihan">
                </div>
                <div id="peopleContainer"></div>
                <button class="btn btn-add" onclick="addPerson()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                    <span class="btn-text">Tambah Orang</span>
                </button>
                <div id="result" class="result"></div>
            </div>
        </div>
    </section>


    <div class="scroll-to-top">
        <svg class="scroll-top-inner" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>

    <script>
        let peopleCount = 0;
        const people = [];
        let totalBillInput;

        document.addEventListener('DOMContentLoaded', function() {
            totalBillInput = new AutoNumeric('#totalBill', {
                currencySymbol: 'Rp ',
                decimalCharacter: ',',
                digitGroupSeparator: '.',
                decimalPlaces: 0,
                minimumValue: '0'
            });

            totalBillInput.domElement.addEventListener('input', updateCalculations);
            addPerson(true);
        });

        function addPerson(isFirst = false) {
            peopleCount++;
            const person = {
                id: peopleCount,
                name: `Orang ${peopleCount}`,
                percentage: isFirst ? 100 : 0
            };
            people.push(person);

            const container = document.getElementById('peopleContainer');
            const personDiv = document.createElement('div');
            personDiv.className = 'person';
            personDiv.id = `person-div-${person.id}`;
            personDiv.innerHTML = `
                <div class="person-header">
                    <input type="text" id="name${person.id}" value="${person.name}" onchange="updateName(${person.id}, this.value)">
                    <button class="btn btn-delete" onclick="removePerson(${person.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"></path></svg>
                    </button>
                </div>
                <input type="range" id="slider${person.id}" min="0" max="100" value="${person.percentage}" class="slider" oninput="updatePercentage(${person.id}, this.value)">
                <div class="person-footer">
                    <span id="percentage${person.id}">${person.percentage}%</span>
                    <span id="amount${person.id}" class="amount"></span>
                </div>
            `;
            container.appendChild(personDiv);
            if (!isFirst) {
                redistributeAfterAdd();
            }
            updateCalculations();
        }

        function updateName(id, newName) {
            const person = people.find(p => p.id === id);
            if (person) {
                person.name = newName;
                updateCalculations();
            }
        }

        function updatePercentage(id, newPercentage) {
            let changedPerson = people.find(p => p.id === id);
            if (!changedPerson) return;

            let newValue = parseInt(newPercentage, 10);
            changedPerson.percentage = newValue;

            let totalPercentage = people.reduce((sum, p) => sum + p.percentage, 0);
            let diff = 100 - totalPercentage;

            let otherPeople = people.filter(p => p.id !== id && p.percentage > 0);
            let lastOtherPerson = otherPeople[otherPeople.length - 1];

            if (otherPeople.length > 0) {
                otherPeople.forEach(p => {
                    let share = p.percentage / (totalPercentage - newValue);
                    p.percentage += diff * share;
                });
            }

            // Recalculate and fix rounding
            let currentTotal = Math.round(people.reduce((sum, p) => sum + p.percentage, 0));
            let roundingError = 100 - currentTotal;
            if (roundingError !== 0 && people.length > 0) {
                people[0].percentage = Math.max(0, people[0].percentage + roundingError);
            }

            updateUI();
        }

        function redistributeAfterAdd() {
            let evenSplit = Math.floor(100 / people.length);
            let remainder = 100 % people.length;

            people.forEach((p, index) => {
                p.percentage = evenSplit + (index < remainder ? 1 : 0);
            });
            updateUI();
        }

        function removePerson(id) {
            if (people.length <= 1) {
                alert("Harus ada minimal satu orang.");
                return;
            }
            const index = people.findIndex(p => p.id === id);
            if (index > -1) {
                people.splice(index, 1);
                const personDiv = document.getElementById(`person-div-${id}`);
                if (personDiv) personDiv.remove();
                redistributeAfterAdd();
            }
        }

        function formatIDR(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount || 0);
        }

        function updateUI() {
            people.forEach(person => {
                const slider = document.getElementById(`slider${person.id}`);
                const percentageSpan = document.getElementById(`percentage${person.id}`);
                const roundedPercentage = Math.round(person.percentage);
                if (slider) slider.value = roundedPercentage;
                if (percentageSpan) percentageSpan.textContent = `${roundedPercentage}%`;
            });
            updateCalculations();
        }

        function updateCalculations() {
            const totalBill = totalBillInput.getNumber() || 0;
            let resultHTML = '<h2>Hasil Pembagian:</h2>';

            let calculatedTotal = 0;
            people.forEach((person, index) => {
                let roundedPercentage = Math.round(person.percentage);
                let amount = (totalBill * roundedPercentage) / 100;
                calculatedTotal += amount;

                // Final adjustment for the last person to match the total bill due to rounding
                if (index === people.length - 1) {
                    amount += totalBill - calculatedTotal;
                }

                const amountSpan = document.getElementById(`amount${person.id}`);
                if (amountSpan) amountSpan.textContent = formatIDR(amount);

                resultHTML +=
                    `<p><span>${person.name} (${roundedPercentage}%)</span> <strong>${formatIDR(amount)}</strong></p>`;
            });

            document.getElementById('result').innerHTML = resultHTML;
        }
    </script>
@endsection
