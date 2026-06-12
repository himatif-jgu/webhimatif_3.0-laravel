<x-filament-panels::page>
    <style>
        .attendance-scanner-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(360px, 0.9fr);
            gap: 24px;
            align-items: start;
        }

        .attendance-scanner-card {
            background: var(--fi-color-white, #ffffff);
            border: 1px solid rgba(17, 24, 39, 0.12);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
            padding: 20px;
        }

        .attendance-scanner-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .attendance-scanner-title {
            color: rgb(17, 24, 39);
            font-size: 16px;
            font-weight: 700;
            line-height: 1.4;
            margin: 0;
        }

        .attendance-scanner-copy {
            color: rgb(75, 85, 99);
            font-size: 14px;
            line-height: 1.6;
            margin: 4px 0 0;
            max-width: 680px;
        }

        .attendance-scanner-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
            min-width: max-content;
        }

        .attendance-camera-frame {
            background: rgb(2, 6, 23);
            border: 1px solid rgba(17, 24, 39, 0.12);
            border-radius: 12px;
            min-height: 320px;
            overflow: hidden;
            position: relative;
        }

        .attendance-camera-frame video,
        .attendance-camera-frame canvas {
            display: block;
            height: 100%;
            min-height: 320px;
            object-fit: cover;
            width: 100%;
        }

        .attendance-camera-reader {
            min-height: 320px;
        }

        .attendance-camera-reader video {
            border-radius: 12px;
        }

        .attendance-camera-overlay {
            inset: 0;
            display: grid;
            padding: 34px;
            place-items: center;
            pointer-events: none;
            position: absolute;
        }

        .attendance-camera-target {
            aspect-ratio: 1 / 1;
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 22px;
            box-shadow: 0 0 0 999px rgba(0, 0, 0, 0.32);
            max-width: 290px;
            width: 72%;
        }

        .attendance-scanner-status {
            border: 1px solid rgba(17, 24, 39, 0.12);
            border-radius: 10px;
            color: rgb(75, 85, 99);
            font-size: 14px;
            line-height: 1.5;
            margin-top: 16px;
            padding: 12px 14px;
        }

        .attendance-scanner-status[data-type="error"] {
            background: rgb(254, 242, 242);
            border-color: rgb(254, 202, 202);
            color: rgb(185, 28, 28);
        }

        .attendance-scanner-status[data-type="success"] {
            background: rgb(240, 253, 244);
            border-color: rgb(187, 247, 208);
            color: rgb(21, 128, 61);
        }

        .attendance-scanner-form {
            margin-top: 18px;
        }

        .attendance-scanner-submit {
            display: flex;
            justify-content: flex-start;
            margin-top: 22px;
        }

        @media (max-width: 1024px) {
            .attendance-scanner-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .attendance-scanner-card {
                padding: 16px;
            }

            .attendance-scanner-header {
                display: block;
            }

            .attendance-scanner-actions {
                justify-content: flex-start;
                margin-top: 14px;
                min-width: 0;
            }

            .attendance-camera-frame,
            .attendance-camera-frame video,
            .attendance-camera-frame canvas,
            .attendance-camera-reader {
                min-height: 260px;
            }
        }
    </style>

    <div x-data="attendanceScanner($wire)" x-on:beforeunload.window="stopCamera()" class="attendance-scanner-grid">
        <section class="attendance-scanner-card">
            <div class="attendance-scanner-header">
                <div>
                    <h2 class="attendance-scanner-title">Camera Scanner</h2>
                    <p class="attendance-scanner-copy">
                        Pilih event di form, lalu arahkan kamera ke QR kartu anggota. Hasil scan akan langsung dicatat.
                    </p>
                </div>

                <div class="attendance-scanner-actions">
                    <x-filament::button type="button" color="gray" x-show="isRunning" x-on:click="stopCamera()">
                        Stop camera
                    </x-filament::button>

                    <x-filament::button type="button" x-show="! isRunning" x-on:click="startCamera()">
                        Start camera
                    </x-filament::button>
                </div>
            </div>

            <div class="attendance-camera-frame">
                <video x-ref="video" playsinline muted x-show="scannerMode === 'native'"></video>
                <div id="attendance-camera-reader" class="attendance-camera-reader" x-show="scannerMode === 'html5'"></div>

                <div class="attendance-camera-overlay">
                    <div class="attendance-camera-target"></div>
                </div>
            </div>

            <div
                class="attendance-scanner-status"
                x-bind:data-type="statusType"
                x-text="message"
            ></div>
        </section>

        <section class="attendance-scanner-card">
            <div>
                <h2 class="attendance-scanner-title">Manual Input</h2>
                <p class="attendance-scanner-copy">
                    Tetap bisa dipakai untuk scanner keyboard atau input NIM manual.
                </p>
            </div>

            <form wire:submit="submit" class="attendance-scanner-form">
                {{ $this->form }}

                <div class="attendance-scanner-submit">
                    <x-filament::button type="submit">
                        Record attendance
                    </x-filament::button>
                </div>
            </form>
        </section>
    </div>

    <script>
        function attendanceScanner(wire) {
            return {
                detector: null,
                html5Scanner: null,
                isProcessing: false,
                isRunning: false,
                lastScanAt: 0,
                message: 'Kamera belum aktif. Klik Start camera untuk mulai scan QR.',
                scannerMode: 'native',
                statusType: 'info',
                stream: null,

                async startCamera() {
                    if (! navigator.mediaDevices?.getUserMedia) {
                        this.statusType = 'error';
                        this.message = 'Browser tidak memberi akses kamera. Buka lewat HTTPS atau localhost, lalu izinkan permission kamera.';
                        return;
                    }

                    if ('BarcodeDetector' in window) {
                        await this.startNativeScanner();
                        return;
                    }

                    await this.startHtml5Scanner();
                },

                async startNativeScanner() {
                    try {
                        this.scannerMode = 'native';
                        this.detector = new BarcodeDetector({ formats: ['qr_code'] });
                        this.stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: { ideal: 'environment' } },
                            audio: false,
                        });

                        this.$refs.video.srcObject = this.stream;
                        await this.$refs.video.play();

                        this.isRunning = true;
                        this.statusType = 'info';
                        this.message = 'Scanner aktif. Arahkan QR ke area kotak.';
                        this.scanNativeLoop();
                    } catch (error) {
                        await this.startHtml5Scanner();
                    }
                },

                async startHtml5Scanner() {
                    try {
                        this.scannerMode = 'html5';
                        this.statusType = 'info';
                        this.message = 'Menyiapkan scanner kamera...';

                        await this.loadHtml5QrCode();

                        this.html5Scanner = new Html5Qrcode('attendance-camera-reader');
                        await this.html5Scanner.start(
                            { facingMode: 'environment' },
                            { fps: 10, qrbox: { width: 240, height: 240 } },
                            (decodedText) => this.handleScan(decodedText),
                            () => {}
                        );

                        this.isRunning = true;
                        this.message = 'Scanner aktif. Arahkan QR ke area kotak.';
                    } catch (error) {
                        this.statusType = 'error';
                        this.message = 'Kamera tidak bisa dibuka. Pastikan browser sudah mendapat izin kamera dan halaman dibuka lewat HTTPS atau localhost.';
                    }
                },

                async loadHtml5QrCode() {
                    if (window.Html5Qrcode) {
                        return;
                    }

                    await new Promise((resolve, reject) => {
                        const script = document.createElement('script');
                        script.src = 'https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js';
                        script.async = true;
                        script.onload = resolve;
                        script.onerror = reject;
                        document.head.appendChild(script);
                    });
                },

                async stopCamera() {
                    this.isRunning = false;

                    if (this.html5Scanner) {
                        try {
                            await this.html5Scanner.stop();
                            await this.html5Scanner.clear();
                        } catch (error) {}

                        this.html5Scanner = null;
                    }

                    if (this.stream) {
                        this.stream.getTracks().forEach((track) => track.stop());
                        this.stream = null;
                    }

                    if (this.$refs.video) {
                        this.$refs.video.srcObject = null;
                    }

                    this.message = 'Scanner kamera berhenti.';
                    this.statusType = 'info';
                },

                async scanNativeLoop() {
                    if (! this.isRunning || ! this.detector || this.scannerMode !== 'native') {
                        return;
                    }

                    try {
                        const codes = await this.detector.detect(this.$refs.video);

                        if (codes.length > 0) {
                            await this.handleScan(codes[0].rawValue);
                        }
                    } catch (error) {
                        this.statusType = 'error';
                        this.message = 'Scanner kamera gagal membaca frame. Coba ulangi atau gunakan input manual.';
                    }

                    requestAnimationFrame(() => this.scanNativeLoop());
                },

                async handleScan(payload) {
                    const now = Date.now();

                    if (this.isProcessing || now - this.lastScanAt < 2500) {
                        return;
                    }

                    this.isProcessing = true;
                    this.lastScanAt = now;
                    this.message = 'QR terbaca. Mencatat presensi...';
                    this.statusType = 'info';

                    try {
                        await wire.set('data.scan_payload', payload);
                        await wire.call('submit');

                        this.statusType = 'success';
                        this.message = 'Presensi tercatat. Siap scan QR berikutnya.';
                    } catch (error) {
                        this.statusType = 'error';
                        this.message = 'Presensi gagal dicatat. Periksa event dan coba ulangi.';
                    } finally {
                        window.setTimeout(() => {
                            this.isProcessing = false;
                        }, 900);
                    }
                },
            };
        }
    </script>
</x-filament-panels::page>
