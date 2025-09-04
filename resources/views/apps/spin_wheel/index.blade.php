@extends('layout_landingpage.apps')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/landing/css/apps/spin_wheel.css') }}" rel="stylesheet">

@endsection



@section('content')
    <div class="boxed_wrapper ltr">
        <div class="loader-wrap">
            <div class="preloader">
                <div class="preloader-close"><i class="icon-27"></i></div>
                <div id="handle-preloader" class="handle-preloader">
                    <div class="animation-preloader">
                        <div class="spinner"></div>
                        <div class="txt-loading"><span data-text-preloader="H" class="letters-loading">H</span><span
                                data-text-preloader="I" class="letters-loading">I</span><span data-text-preloader="M"
                                class="letters-loading">M</span><span data-text-preloader="A"
                                class="letters-loading">A</span><span data-text-preloader="T"
                                class="letters-loading">T</span><span data-text-preloader="I"
                                class="letters-loading">I</span><span data-text-preloader="F"
                                class="letters-loading">F</span></div>
                    </div>
                </div>
            </div>
        </div>
      
        <section class="page-title centred pt_110">
            <div class="auto-container">
                <div class="content-box">
                    <h1>Spin Wheels - Himatif JGU</h1>
                    <ul class="bread-crumb clearfix">
                        <li><a href="index.html">Himatif</a></li>
                        <li>-</li>
                        <li>JGU</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="spin-wheel-section pt_80 pb_120">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="control-card">
                            <div class="spin-container">
                                <div class="spin-ticker"></div>
                                <canvas id="spin-wheel-canvas" width="500" height="500"></canvas>
                            </div>
                        </div>
                        <div class="control-card">
                            <h4><i class="fas fa-trophy" style="color: #ffc107;"></i> Hasil</h4>
                            <div id="results-list">
                                <p>Belum ada hasil.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="control-card">
                            <h4><i class="fas fa-edit"></i> Kelola Kategori/Kelompok</h4>
                            <div class="category-input-group">
                                <input type="text" id="category-name-input" class="form-control"
                                    placeholder="Cth: Kelompok 1/Ketuplak">
                                <input type="number" id="category-capacity-input" class="form-control capacity-input"
                                    value="1" min="1" title="Jumlah anggota">
                                <button id="add-category-btn" class="theme-btn btn-one"
                                    style="padding: 10px 20px;">Add</button>
                            </div>
                            <ul id="categories-list"></ul>
                        </div>

                        <div class="control-card">
                            <h4><i class="fas fa-cogs"></i> Panel Kontrol</h4>
                            <div class="form-group">
                                <label>Nama Peserta <span>* (satu per baris)</span></label>
                                <textarea id="participants-input" class="form-control" placeholder="Andi Budiman&#10;Citra Lestari"
                                    style="min-height: 120px;"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label>Pilih Kategori Tujuan <span>*</span></label>
                                <select id="category-select" class="form-control"></select>
                            </div>
                            <div class="form-group message-btn mt-3">
                                <button type="button" id="spin-button" class="theme-btn btn-one" style="width:100%;">Mulai
                                    Acak!</button>
                            </div>
                        </div>

                        <div class="control-card">
                            <h4><i class="fas fa-users"></i> Daftar Peserta Tersisa</h4>
                            <ul id="remaining-participants-list">
                                <li>Daftar peserta kosong.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="scroll-to-top"><svg class="scroll-top-inner" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg></div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/landing/js/jquery.lettering.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/jquery.circleType.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- STATE MANAGEMENT ---
            let state = {
                participants: [],
                categories: [],
                currentRotation: 0,
                lastSelectedCategory: null,
                isSpinning: false,
            };

            // --- DOM ELEMENTS ---
            const dom = {
                canvas: document.getElementById('spin-wheel-canvas'),
                spinButton: document.getElementById('spin-button'),
                participantsInput: document.getElementById('participants-input'),
                remainingList: document.getElementById('remaining-participants-list'),
                categoryNameInput: document.getElementById('category-name-input'),
                categoryCapacityInput: document.getElementById('category-capacity-input'),
                addCategoryBtn: document.getElementById('add-category-btn'),
                categoriesList: document.getElementById('categories-list'),
                categorySelect: document.getElementById('category-select'),
                resultsList: document.getElementById('results-list'),
            };

            const ctx = dom.canvas.getContext('2d');
            const colors = ["#ff6b6b", "#feca57", "#48dbfb", "#1dd1a1", "#f368e0", "#ff9f43", "#0abde3",
                "#10ac84", "#54a0ff", "#ee5253"
            ];

            // --- RENDER FUNCTIONS (LENGKAP) ---
            const renderAll = () => {
                renderCategories();
                renderRemainingParticipants();
                renderResults();
                drawWheel();
                checkSpinButtonState();
            };

            const renderCategories = () => {
                const select = $(dom.categorySelect);
                select.empty().append('<option value="">-- Pilih Kategori --</option>');
                dom.categoriesList.innerHTML = '';

                if (state.categories.length === 0) {
                    dom.categoriesList.innerHTML = '<li>Belum ada kategori ditambahkan.</li>';
                } else {
                    state.categories.forEach((cat, index) => {
                        const isFilled = cat.members.length >= cat.capacity;
                        const li = document.createElement('li');
                        li.innerHTML = `
                        <span>${cat.name} <span class="category-progress">(${cat.members.length}/${cat.capacity})</span></span>
                        <button class="remove-category-btn" data-index="${index}" title="Hapus Kategori">&times;</button>
                    `;
                        if (isFilled) li.style.opacity = '0.5';
                        dom.categoriesList.appendChild(li);

                        if (!isFilled) {
                            select.append(
                                `<option value="${cat.name}">${cat.name} (${cat.members.length}/${cat.capacity})</option>`
                            );
                        }
                    });
                }

                if (state.lastSelectedCategory && select.find(
                        `option[value="${state.lastSelectedCategory}"]`).length > 0) {
                    select.val(state.lastSelectedCategory);
                }

                select.niceSelect('update');
            };

            const renderResults = () => {
                dom.resultsList.innerHTML = '';
                const categoriesWithMembers = state.categories.filter(c => c.members.length > 0);

                if (categoriesWithMembers.length === 0) {
                    dom.resultsList.innerHTML = '<p>Belum ada hasil.</p>';
                } else {
                    categoriesWithMembers.forEach(cat => {
                        const groupDiv = document.createElement('div');
                        groupDiv.className = 'result-group';

                        let memberListHTML = cat.members.map(member => `<li>${member}</li>`).join(
                            '');

                        groupDiv.innerHTML = `
                        <div class="result-group-header">${cat.name} <span class="category-progress">(${cat.members.length}/${cat.capacity})</span></div>
                        <ul class="result-group-members">${memberListHTML}</ul>
                    `;
                        dom.resultsList.appendChild(groupDiv);
                    });
                }
            };

            const drawWheel = () => {
                const participants = state.participants;
                const numParticipants = participants.length;
                const centerX = dom.canvas.width / 2;
                const centerY = dom.canvas.height / 2;

                ctx.clearRect(0, 0, dom.canvas.width, dom.canvas.height);

                if (numParticipants === 0) {
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = '20px Outfit';
                    ctx.fillStyle = '#aaa';
                    ctx.fillText('Tambahkan Peserta', centerX, centerY);
                    ctx.restore();
                    return;
                }

                const arcSize = 2 * Math.PI / numParticipants;
                const radius = centerX - 10;

                ctx.save();
                ctx.translate(centerX, centerY);

                for (let i = 0; i < numParticipants; i++) {
                    const angle = i * arcSize;
                    ctx.beginPath();
                    ctx.fillStyle = colors[i % colors.length];
                    ctx.moveTo(0, 0);
                    ctx.arc(0, 0, radius, angle, angle + arcSize);
                    ctx.closePath();
                    ctx.fill();
                    ctx.save();
                    ctx.rotate(angle + arcSize / 2);
                    ctx.textAlign = 'right';
                    ctx.fillStyle = '#fff';
                    ctx.font = '16px Outfit';
                    const name = participants[i].length > 15 ? participants[i].substring(0, 13) + '...' :
                        participants[i];
                    ctx.fillText(name, radius - 15, 5);
                    ctx.restore();
                }
                ctx.restore();
            };

            const renderRemainingParticipants = () => {
                dom.remainingList.innerHTML = '';
                if (state.participants.length === 0) {
                    dom.remainingList.innerHTML = '<li>Semua peserta sudah terpilih.</li>';
                } else {
                    state.participants.forEach(p => {
                        const li = document.createElement('li');
                        li.textContent = p;
                        dom.remainingList.appendChild(li);
                    });
                }
            };

            const checkSpinButtonState = () => {
                const availableCategories = state.categories.some(c => c.members.length < c.capacity);
                const hasParticipants = state.participants.length > 0;
                dom.spinButton.disabled = state.isSpinning || !(availableCategories && hasParticipants);
            };

            function runSingleSpinAnimation() {
                return new Promise((resolve) => {
                    if (state.participants.length === 0) {
                        resolve(null);
                        return;
                    }
                    const spinDuration = 5000;
                    const randomSpins = Math.random() * 5 + 5;
                    const stopAngle = Math.random() * 2 * Math.PI;
                    const totalRotation = state.currentRotation + (randomSpins * 2 * Math.PI) +
                        stopAngle;

                    dom.canvas.style.transition =
                        `transform ${spinDuration}ms cubic-bezier(0.25, 0.1, 0.25, 1)`;
                    dom.canvas.style.transform = `rotate(${totalRotation}rad)`;

                    setTimeout(() => {
                        state.currentRotation = totalRotation % (2 * Math.PI);
                        const finalAngle = (2 * Math.PI) - state.currentRotation;
                        const arcSize = 2 * Math.PI / state.participants.length;
                        let winnerIndex = Math.floor(finalAngle / arcSize) % state.participants
                            .length;

                        resolve({
                            winner: state.participants[winnerIndex],
                            winnerIndex: winnerIndex
                        });
                    }, spinDuration);
                });
            }

            async function performSequentialSpins(category, needed) {
                state.isSpinning = true;
                checkSpinButtonState();

                let winners = [];
                for (let i = 0; i < needed; i++) {
                    if (state.participants.length === 0) {
                        Swal.fire('Proses Berhenti', 'Semua peserta sudah terpilih.', 'warning');
                        break;
                    }

                    const result = await runSingleSpinAnimation();
                    if (!result) continue;

                    const {
                        winner,
                        winnerIndex
                    } = result;

                    winners.push(winner);
                    category.members.push(winner);
                    state.participants.splice(winnerIndex, 1);
                    dom.participantsInput.value = state.participants.join('\n');
                    renderAll();

                    if (i < needed - 1) {
                        await new Promise(resolve => setTimeout(resolve, 1500));
                    }
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Pemilihan Selesai!',
                    html: `<b>${winners.length}</b> anggota baru telah ditambahkan ke kategori <b>"${category.name}"</b>.`,
                });

                state.isSpinning = false;
                checkSpinButtonState();
            }

            // --- EVENT LISTENERS (LENGKAP) ---
            dom.addCategoryBtn.addEventListener('click', () => {
                const name = dom.categoryNameInput.value.trim();
                const capacity = parseInt(dom.categoryCapacityInput.value, 10);
                if (name && capacity > 0) {
                    state.categories.push({
                        name,
                        capacity,
                        members: []
                    });
                    dom.categoryNameInput.value = '';
                    dom.categoryCapacityInput.value = '1';
                    renderAll();
                } else {
                    Swal.fire('Input Tidak Valid',
                        'Nama kategori tidak boleh kosong dan jumlah anggota minimal 1.', 'error');
                }
            });

            dom.categoryNameInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    dom.addCategoryBtn.click();
                }
            });
            dom.categoryCapacityInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    dom.addCategoryBtn.click();
                }
            });

            dom.spinButton.addEventListener('click', async () => {
                const selectedCategoryName = dom.categorySelect.value;
                if (!selectedCategoryName) {
                    Swal.fire('Perhatian!', 'Silakan pilih kategori tujuan terlebih dahulu.',
                        'warning');
                    return;
                }

                const category = state.categories.find(c => c.name === selectedCategoryName);
                if (!category) return;

                const needed = category.capacity - category.members.length;
                if (needed <= 0) {
                    Swal.fire('Kategori Penuh', 'Kategori ini sudah terisi penuh.', 'info');
                    return;
                }

                if (state.participants.length < needed) {
                    Swal.fire('Peserta Kurang',
                        `Tidak cukup peserta! Butuh ${needed} orang, hanya tersedia ${state.participants.length}.`,
                        'error');
                    return;
                }

                state.lastSelectedCategory = selectedCategoryName;
                await performSequentialSpins(category, needed);
                renderAll();
            });

            dom.categoriesList.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-category-btn')) {
                    const index = e.target.getAttribute('data-index');
                    state.categories.splice(index, 1);
                    renderAll();
                }
            });

            dom.participantsInput.addEventListener('input', () => {
                const rawInput = dom.participantsInput.value;
                state.participants = rawInput.split('\n').map(p => p.trim()).filter(p => p.length > 0);
                renderAll();
            });

            // --- INITIALIZATION ---
            renderAll();
        });
    </script>
@endsection
