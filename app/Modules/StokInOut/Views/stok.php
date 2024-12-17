<?php $this->extend("layouts/backend"); ?>
<?php $this->section("content"); ?>
<template>
    <h1 class="font-weight-medium mb-2"><?= $title ?> &nbsp;<span class="font-weight-regular">{{startDate}} {{startDate != '' ? "&mdash;": ""}} {{endDate}}</span>
        <template>
            <v-menu v-model="menu" :close-on-content-click="false" offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-calendar-filter</v-icon>
                    </v-btn>
                </template>
                <v-card width="250">
                    <v-card-text>
                        <p class="mb-1"><strong>Filter:</strong></p>
                        <div class="mb-3">
                            <a @click="hariini" title="Hari Ini" alt="Hari Ini">Hari Ini</a> &bull;
                            <a @click="tujuhHari" title="7 Hari Kemarin" alt="7 Hari Kemarin">7 Hari terakhir</a> &bull;
                            <a @click="bulanIni" title="Bulan Ini" alt="Bulan Ini">Bulan Ini</a> &bull;
                            <a @click="satuBulan" title="1 Bulan Lalu" alt="1 Bulan Lalu">30 Hari terakhir</a> &bull;
                            <a @click="tigaBulan" title="3 Bulan Lalu" alt="3 Bulan Lalu">3 Bulan terakhir</a> &bull;
                            <a @click="tahunIni" title="Tahun Ini" alt="Tahun Ini">Tahun Ini</a> &bull;
                            <a @click="tahunLalu" title="Tahun Lalu" alt="Tahun Lalu">Tahun Lalu</a> &bull;
                            <a @click="reset" title="Reset" alt="Reset">Reset</a>
                        </div>
                        <p class="mb-1"><strong>Custom:</strong></p>
                        <p class="mb-1">Dari Tanggal - Sampai Tanggal</p>
                        <v-text-field v-model="startDate" type="date"></v-text-field>
                        <v-text-field v-model="endDate" type="date"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="menu = false">
                            <?= lang('App.close'); ?>
                        </v-btn>
                        <v-btn color="primary" text @click="handleSubmit" :loading="loading">
                            Filter
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </template>
    </h1>
    <v-card>
        <v-card-title>
            <v-btn large color="primary" dark @click="modalAddOpen" class="mr-3" elevation="1">
                <v-icon>mdi-plus</v-icon> <?= lang('App.add'); ?>
            </v-btn>
            <v-btn large color="info" dark @click="modalAddScannerOpen" elevation="1">
                <v-icon>mdi-barcode-scan</v-icon> &nbsp;Scanner
            </v-btn>
            <v-spacer></v-spacer>
            <v-select v-model="search" label="Filter <?= lang('App.type'); ?>" :items="dataJenis" item-text="text" item-value="value" prepend-icon="mdi-filter" @change="handleSubmit" @click:clear="handleSubmit" clearable class="mr-3" style="max-width: 250px !important;"></v-select>

            <v-text-field v-model="search" v-on:keydown.enter="handleSubmit" @click:clear="handleSubmit" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line clearable></v-text-field>
        </v-card-title>
        <v-data-table v-model="detail" :headers="dataTable" item-key="id_stok" show-select :items="data" :options.sync="options" :server-items-length="totalData" :items-per-page="10" :loading="loading" :search="search" loading-text="<?= lang('App.loadingWait'); ?>">
            <!-- <template v-slot:top>
                
            </template> -->
            <template v-slot:item="{ item, isSelected, select }">
                <tr :class="isSelected ? 'grey lighten-2':''" @click="toggle(isSelected,select,$event)">
                    <td>
                        <v-icon color="primary" v-if="isSelected">mdi-checkbox-marked</v-icon>
                        <v-icon v-else>mdi-checkbox-blank-outline</v-icon>
                    </td>
                    <td>{{item.nama_toko}}</td>
                    <td>
                        <a :href="'<?= base_url('barang'); ?>?search=' + item.kode_barang" target="_blank" title="item.kode_barang" alt="item.kode_barang">{{item.kode_barang}}</a>
                    </td>
                    <td>{{item.barcode}}</td>
                    <td>{{item.nama_barang}}</td>
                    <td>{{item.jenis == 'in' ? 'Stok Masuk':'Stok Keluar'}}</td>
                    <td>{{item.jumlah}}</td>
                    <td>{{RibuanLocale(item.nilai)}}</td>
                    <td>{{dayjs(item.created_at).format('DD-MM-YYYY HH:mm')}}</td>
                    <td>
                        <v-btn icon color="primary" class="mr-2" @click="editItem(item)" title="Edit" alt="Edit">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn icon color="error" @click="deleteItem(item)" title="Delete" alt="Delete">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
                <tr v-show="isSelected">
                    <td colspan="11">
                        Keterangan: {{item.keterangan}} - User: {{item.nama_user}}
                    </td>
                </tr>
            </template>
            <template slot="body.append">

            </template>
        </v-data-table>
    </v-card>
</template>

<!-- Modal Add -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalAdd" scrollable persistent max-width="600px">
            <v-card>
                <v-card-title><?= lang('App.add') . ' ' . $title; ?><span v-show="scanner == true">: Barcode Scanner</span>
                    <v-spacer></v-spacer>
                    <div v-if="scanner == false">
                        <v-btn icon @click="modalAddClose">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </div>
                    <div v-else>
                        <v-btn icon @click="modalAddScannerClose">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </div>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-radio-group v-model="radioJenis" row v-show="scanner == true">
                        <v-radio label="Stok Masuk" value="in"></v-radio>
                        <v-radio label="Stok Keluar" value="out"></v-radio>
                    </v-radio-group>
                    <v-form v-model="valid" ref="form">
                        <v-select v-model="idToko" label="Outlet" :items="dataToko" :item-text="dataToko =>`${dataToko.id_toko}. ${dataToko.nama_toko}, ${dataToko.alamat_toko}`" item-value="id_toko" :error-messages="id_tokoError" outlined></v-select>

                        <div v-if="scanner == false">
                            <v-text-field v-model="barcodeBarang" label="<?= lang('App.search'); ?> <?= lang('App.items'); ?>: Barcode" prepend-inner-icon="mdi-magnify" outlined :loading="loading2" loader-height="3" clearable @click="modalCariBarangOpen" @click:clear="clearCariBarang" ref="inputRef" :disabled="idToko == '' ? true:false"></v-text-field>
                        </div>
                        <div v-else>
                            <v-text-field v-model="scan" prepend-inner-icon="mdi-magnify" label="Scan Barcode" placeholder="" v-on:keydown.enter="scanBarang" class="mb-3" outlined hide-details clearable autofocus :autofocus="'autofocus'" append-icon="mdi-camera" @click:append="dialogCameraOpen" ref="inputRef" :disabled="idToko == '' ? true:false"></v-text-field>
                        </div>

                        <v-text-field v-model="barcodeBarang" type="text" label="Barcode" filled readonly v-show="scanner == true"></v-text-field>

                        <v-text-field v-model="kodeBarang" type="text" label="Code Item" filled readonly></v-text-field>

                        <v-text-field v-model="namaBarang" type="text" label="Nama <?= lang('App.items'); ?>" filled readonly></v-text-field>

                        <v-select v-model="jenis" label="<?= lang('App.type'); ?>" :items="dataJenis" item-text="text" item-value="value" :error-messages="jenisError" outlined v-show="scanner == false"></v-select>

                        <v-text-field v-model="jumlah" type="number" label="Jumlah" :error-messages="jumlahError" outlined prepend-icon="mdi-minus" append-outer-icon="mdi-plus" @click:append-outer="increment()" @click:prepend="decrement()"></v-text-field>

                        <v-textarea v-model="keterangan" label="<?= lang('App.description'); ?>" :error-messages="keteranganError" rows="3" outlined v-show="scanner == false"></v-textarea>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="saveStok" :loading="loading1" elevation="1" :disabled="idBarang == ''">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.save') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Add -->

<!-- Modal Edit -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalEdit" scrollable persistent max-width="600px">
            <v-card>
                <v-card-title><?= lang('App.edit') ?> <?= $title; ?>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalEditClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="py-5">
                    <v-form ref="form" v-model="valid">
                        <v-textarea v-model="keteranganEdit" type="text" label="Keterangan" rows="3" outlined></v-textarea>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="updateStok" :loading="loading" elevation="1">
                        <v-icon>mdi-content-save</v-icon> <?= lang('App.update') ?>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Edit -->

<!-- Modal Delete -->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalDelete" persistent max-width="600px">
            <v-card class="pa-2">
                <v-card-title>
                    <v-icon color="error" class="mr-2" x-large>mdi-alert-octagon</v-icon> <?= lang('App.confirmDelete'); ?>
                </v-card-title>
                <v-card-text>
                    <div class="mt-5 py-5">
                        <h2 class="font-weight-regular"><?= lang('App.delConfirm'); ?></h2>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="modalDelete = false" large elevation="1"><?= lang('App.close'); ?></v-btn>
                    <v-btn color="red" dark @click="deleteStok" :loading="loading" elevation="1" large><?= lang('App.delete'); ?></v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<!-- Modal Show Data Barang-->
<template>
    <v-row justify="center">
        <v-dialog v-model="modalShow" scrollable persistent max-width="900px">
            <v-card>
                <v-card-title>
                    <?= lang('App.listItems'); ?>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="modalShow = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field v-model="searchBarang" append-icon="mdi-magnify" label="<?= lang('App.search') ?>" single-line hide-details clearable>
                    </v-text-field>
                    <v-data-table item-key="id_barang" :headers="tbBarang" :items="dataBarang" :items-per-page="10" :loading="loading" :search="searchBarang" class="elevation-0" loading-text="<?= lang('App.loadingWait'); ?>" dense>
                        <template v-slot:top>

                        </template>
                        <template v-slot:item="{item}">
                            <tr :class="item.stok <= item.stok_min ? 'red lighten-4':''">
                                <td>{{item.barcode}}</td>
                                <td>{{item.kode_barang}}</td>
                                <td>{{item.nama_barang}}</td>
                                <td>
                                    <v-btn color="primary" small @click="selectBarang(item)" :loading="loading3">
                                        <v-icon>mdi-check</v-icon> Select
                                    </v-btn>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Delete -->

<!-- Start Modal Camera -->
<template>
    <v-row justify="center">
        <v-dialog v-model="dialogCamera" width="900" persistent scrollable>
            <v-card>
                <v-card-title>
                    Camera
                    <v-spacer></v-spacer>
                    <v-btn icon @click="dialogCameraClose">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <qrcode-scanner @result="onScanCamera" />
                <!--<p class="error--text">{{ error }}</p>
                    <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit"></qrcode-stream>-->
            </v-card>
        </v-dialog>
    </v-row>
</template>
<!-- End Modal Camera -->

<!-- Loading2 -->
<v-dialog v-model="loading2" hide-overlay persistent width="300">
    <v-card>
        <v-card-text class="pt-3">
            <?= lang('App.loadingWait'); ?>
            <v-progress-linear indeterminate color="primary" class="mb-0"></v-progress-linear>
        </v-card-text>
    </v-card>
</v-dialog>
<!-- -->

<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    // Mendapatkan Token JWT
    const token = JSON.parse(localStorage.getItem('access_token'));

    // Menambahkan Auth Bearer Token yang didapatkan sebelumnya
    const options = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    // Deklarasi errorKeys
    var errorKeys = []

    // Initial Data
    dataVue = {
        ...dataVue,
        tabsMenu: "master",
        buttonMenu: "stok",
        modalAdd: false,
        modalEdit: false,
        modalDelete: false,
        modalShow: false,
        search: "<?= $search; ?>",
        dataStok: [],
        totalData: 0,
        data: [],
        options: {},
        dataTable: [{
            text: 'Outlet',
            value: 'nama_toko'
        }, {
            text: 'Code Item',
            value: 'kode_barang'
        }, {
            text: 'Barcode',
            value: 'barcode'
        }, {
            text: '<?= lang('App.items'); ?>',
            value: 'nama_barang'
        }, {
            text: 'Jenis',
            value: 'jenis'
        }, {
            text: 'Jumlah',
            value: 'jumlah'
        }, {
            text: 'Nilai',
            value: 'nilai'
        }, {
            text: '<?= lang('App.date'); ?>',
            value: 'created_at'
        }, {
            text: 'Aksi',
            value: 'actions',
            sortable: false
        }, ],
        idStok: "",
        jenis: "",
        jenisError: "",
        dataJenis: [{
            text: 'Stok Masuk',
            value: 'in'
        }, {
            text: 'Stok Keluar',
            value: 'out'
        }],
        jumlah: 0,
        jumlahError: "",
        keterangan: "",
        keteranganError: "",
        keteranganEdit: "",
        menu: false,
        startDate: "<?= $startDate; ?>",
        endDate: "<?= $endDate; ?>",
        pencarian: "",
        dataBarang: [],
        selected: [],
        searchBarang: "",
        pageCount: 0,
        currentPage: 1,
        limitPage: 10,
        activeColor1: "primary",
        activeColor2: "",
        activeColor3: "",
        tbBarang: [{
            text: 'Barcode',
            value: 'barcode'
        }, {
            text: 'Code Item',
            value: 'kode_barang'
        }, {
            text: 'Nama Barang',
            value: 'nama_barang'
        }, {
            text: '<?= lang('App.action') ?>',
            value: 'actions',
            sortable: false
        }, ],
        idBarang: "",
        kodeBarang: "",
        barcodeBarang: "",
        namaBarang: "",
        detail: [],
        scan: "",
        scanner: false,
        radioJenis: "in",
        dialogCamera: false,
        camera: false,
        dataToko: [],
        idToko: "",
        id_tokoError: ""
    }

    // Vue Created
    // Created: Dipanggil secara sinkron setelah instance dibuat
    createdVue = function() {
        this.getStok();
    }

    watchVue = {
        ...watchVue,
        options: {
            handler() {
                this.getDataFromApi()
            },
            deep: true,
        },

        dataStok: function() {
            if (this.dataStok != '') {
                // Call server-side paginate and sort
                this.getDataFromApi();
            }
        },

        radioJenis: function() {
            if (this.radioJenis == 'in') {
                this.jenis = 'in';
                //Autofocus
                let input = document.querySelector('[autofocus]');
                if (input) {
                    input.focus()
                }
            } else if (this.radioJenis == 'out') {
                this.jenis = 'out';
                //Autofocus
                let input = document.querySelector('[autofocus]');
                if (input) {
                    input.focus()
                }
            }
        },

        scan: function() {
            if (this.camera == true) {
                this.scanBarang();
            }
        }
    }

    // Vue Methods
    // Methods: Metode-metode yang kemudian digabung ke dalam Vue instance
    methodsVue = {
        ...methodsVue,
        // Format Ribuan Rupiah versi 1
        RibuanLocale(key) {
            const rupiah = 'Rp' + Number(key).toLocaleString('id-ID');
            return rupiah
        },

        // Format Ribuan Rupiah versi 2
        Ribuan(key) {
            const format = key.toString().split('').reverse().join('');
            const convert = format.match(/\d{1,3}/g);
            const rupiah = 'Rp' + convert.join('.').split('').reverse().join('');
            return rupiah;
        },

        // Modal Add Open
        modalAddOpen: function() {
            this.modalAdd = true;
            this.getToko();
        },
        modalAddClose: function() {
            this.jenis = "";
            this.jumlah = 0;
            this.keterangan = "";
            this.modalAdd = false;
            this.$refs.form.resetValidation();
        },

        // Modal Add Open Scanner
        modalAddScannerOpen: function() {
            this.modalAdd = true;
            this.getToko();
            this.scanner = true;
            this.jenis = 'in';
            this.keterangan = "Added via Scanner";
        },
        modalAddScannerClose: function() {
            this.scanner = false;
            this.jenis = "";
            this.jumlah = 0;
            this.keterangan = "";
            this.dataScan = "";
            this.idBarang = "";
            this.kodeBarang = "";
            this.barcodeBarang = "";
            this.namaBarang = "";
            this.modalAdd = false;
            this.$refs.form.resetValidation();
        },

        // Scan Camera
        dialogCameraOpen: function() {
            this.dialogCamera = true;
            this.$refs.inputRef.reset();
        },

        dialogCameraClose: function() {
            this.dialogCamera = false;
        },

        async onScanCamera(decodedText, decodedResult) {
            this.scan = `${decodedText}`;
            this.camera = true;
            this.dialogCameraClose();
        },

        toggle(isSelected, select, e) {
            select(!isSelected)
        },

        increment() {
            this.jumlah++;
            if (this.jumlah < 0) return;

            //Autofocus
            let input = document.querySelector('[autofocus]');
            if (input) {
                input.focus()
            }
        },
        decrement() {
            this.jumlah--;
            if (this.jumlah < 0) {
                this.jumlah = 0;
            }

            //Autofocus
            let input = document.querySelector('[autofocus]');
            if (input) {
                input.focus()
            }
        },

        // Filter Date
        reset: function() {
            this.startDate = "";
            this.endDate = "";
        },
        tujuhHari: function() {
            this.startDate = "<?= $tujuhHari; ?>";
            this.endDate = "<?= $kemarin; ?>";
        },
        hariini: function() {
            this.startDate = "<?= $hariini; ?>";
            this.endDate = "<?= $hariini; ?>";
        },
        bulanIni: function() {
            this.startDate = "<?= $awalBulan; ?>";
            this.endDate = "<?= $akhirBulan; ?>";
        },
        satuBulan: function() {
            this.startDate = "<?= $satuBulanAwal; ?>";
            this.endDate = "<?= $satuBulanAkhir; ?>";
        },
        tigaBulan: function() {
            this.startDate = "<?= $tigaBulanAwal; ?>";
            this.endDate = "<?= $tigaBulanAkhir; ?>";
        },
        tahunIni: function() {
            this.startDate = "<?= $awalTahun; ?>";
            this.endDate = "<?= $akhirTahun; ?>";
        },
        tahunLalu: function() {
            this.startDate = "<?= $awalTahunLalu; ?>";
            this.endDate = "<?= $akhirTahunLalu; ?>";
        },

        // Handle Submit Filter
        handleSubmit: function() {
            if (this.startDate != '' && this.endDate != '') {
                this.getStokFiltered();
                this.menu = false;
            } else {
                this.getStok();
                this.startDate = "";
                this.endDate = "";
                this.menu = false;
            }
        },

        // Server-side paginate and sort
        getDataFromApi() {
            this.loading = true
            this.fetchData().then(data => {
                this.data = data.items
                this.totalData = data.total
                this.loading = false
            })
        },
        fetchData() {
            return new Promise((resolve, reject) => {
                const {
                    sortBy,
                    sortDesc,
                    page,
                    itemsPerPage
                } = this.options

                let search = this.search ?? "".trim();

                let items = this.dataStok
                const total = items.length

                if (search == search.toLowerCase()) {
                    items = items.filter(item => {
                        return Object.values(item)
                            .join(",")
                            .toLowerCase()
                            .includes(search);
                    });
                } else {
                    items = items.filter(item => {
                        return Object.values(item)
                            .join(",")
                            .includes(search);
                    });
                }

                if (sortBy.length === 1 && sortDesc.length === 1) {
                    items = items.sort((a, b) => {
                        const sortA = a[sortBy[0]]
                        const sortB = b[sortBy[0]]

                        if (sortDesc[0]) {
                            if (sortA < sortB) return 1
                            if (sortA > sortB) return -1
                            return 0
                        } else {
                            if (sortA < sortB) return -1
                            if (sortA > sortB) return 1
                            return 0
                        }
                    })
                }

                if (itemsPerPage > 0) {
                    items = items.slice((page - 1) * itemsPerPage, page * itemsPerPage)
                }

                setTimeout(() => {
                    resolve({
                        items,
                        total,
                    })
                }, 100)
            })
        },
        // End Server-side paginate and sort

        // Get Stok
        getStok: function() {
            this.loading = true;
            axios.get(`<?= base_url() ?>api/stok`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataStok = data.data;
                        //console.log(this.settingData);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataStok = data.data;
                        this.data = data.data;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Stok Filtered
        getStokFiltered: function() {
            this.loading = true;
            axios.get(`<?= base_url() ?>api/stok?tgl_start=${this.startDate}&tgl_end=${this.endDate}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataStok = data.data;
                        //console.log(this.settingData);
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataStok = data.data;
                        this.data = data.data;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Save Stok
        saveStok: function() {
            this.loading1 = true;
            axios.post('<?= base_url(); ?>api/stok/save', {
                    id_barang: this.idBarang,
                    kode_barang: this.kodeBarang,
                    barcode: this.barcodeBarang,
                    jenis: this.jenis,
                    jumlah: parseInt(this.jumlah),
                    keterangan: this.keterangan,
                    id_toko: this.idToko
                }, options)
                .then(res => {
                    // handle success
                    this.loading1 = false
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getStok();
                        this.idBarang = "";
                        this.kodeBarang = "";
                        this.barcodeBarang = "";
                        this.namaBarang = "";
                        this.jenis = "";
                        this.jumlah = 0;
                        this.keterangan = "";
                        this.modalAdd = false;
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => this.notifType = "", 4000);
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.modalAdd = true;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading1 = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Item Edit
        editItem: function(item) {
            this.modalEdit = true;
            this.idStok = item.id_stok;
            this.keteranganEdit = item.keterangan;
        },
        modalEditClose: function() {
            this.modalEdit = false;
            this.$refs.form.resetValidation();
        },

        //Update
        updateStok: function() {
            this.loading = true;
            axios.put(`<?= base_url(); ?>api/stok/update/${this.idStok}`, {
                    keterangan: this.keteranganEdit,
                }, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getStok();
                        this.modalEdit = false;
                        this.$refs.form.resetValidation();
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        errorKeys = Object.keys(data.data);
                        errorKeys.map((el) => {
                            this[`${el}Error`] = data.data[el];
                        });
                        if (errorKeys.length > 0) {
                            setTimeout(() => this.notifType = "", 4000);
                            setTimeout(() => errorKeys.map((el) => {
                                this[`${el}Error`] = "";
                            }), 4000);
                        }
                        this.modalEdit = true;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Item Delete
        deleteItem: function(item) {
            this.modalDelete = true;
            this.idStok = item.id_stok;
        },

        // Delete
        deleteStok: function() {
            this.loading = true;
            axios.delete(`<?= base_url() ?>api/stok/delete/${this.idStok}`, options)
                .then(res => {
                    // handle success
                    this.loading = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.getStok();
                        this.modalDelete = false;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.modalDelete = true;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Modal Show Barang
        modalCariBarangOpen: function() {
            this.modalShow = true;
            this.getBarang();
        },

        clearCariBarang: function() {
            this.pencarian = "";
            this.dataBarang = [];
            this.selected = [];
            this.idBarang = "";
            this.kodeBarang = "";
            this.barcodeBarang = "";
            this.namaBarang = "";
        },

        // Get Data Barang
        getBarang: function() {
            this.loading2 = true;
            axios.get(`<?= base_url(); ?>api/barang?outlet=${this.idToko}`, options)
                .then(res => {
                    // handle success
                    this.loading2 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataBarang = data.data;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataBarang = data.data;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading2 = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Select Barang
        selectBarang: function(item) {
            this.loading3 = true;
            axios.get(`<?= base_url(); ?>api/barang/${item.id_barang}`, options)
                .then(res => {
                    // handle success
                    this.loading3 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.selected = data.data;
                        this.idBarang = this.selected.id_barang;
                        this.kodeBarang = this.selected.kode_barang;
                        this.barcodeBarang = this.selected.barcode;
                        this.namaBarang = this.selected.nama_barang;
                        this.modalShow = false;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.selected = data.data;
                        this.idBarang = "";
                        this.kodeBarang = "";
                        this.barcodeBarang = "";
                        this.namaBarang = "";
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading3 = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Scan Barang
        scanBarang: function() {
            this.loading4 = true;
            axios.get(`<?= base_url(); ?>api/find_barang?outlet=${this.idToko}&query=${this.scan}`, options)
                .then(res => {
                    // handle success
                    this.loading4 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.$refs.inputRef.reset();
                        this.camera = false;
                        this.dataScan = data.data;
                        this.idBarang = this.dataScan.id_barang;
                        this.kodeBarang = this.dataScan.kode_barang;
                        this.barcodeBarang = this.dataScan.barcode;
                        this.namaBarang = this.dataScan.nama_barang;
                        this.jumlah += 1;
                    } else {
                        this.snackbar = true;
                        this.snackbarMessage = data.message;
                        this.dataScan = data.data;
                        this.$refs.inputRef.reset();
                        this.camera = false;
                        this.idBarang = "";
                        this.kodeBarang = "";
                        this.barcodeBarang = "";
                        this.namaBarang = "";
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading4 = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },

        // Get Toko
        getToko: function() {
            this.loading1 = true;
            axios.get('<?= base_url(); ?>api/toko', options)
                .then(res => {
                    // handle success
                    this.loading1 = false;
                    var data = res.data;
                    if (data.status == true) {
                        this.dataToko = data.data;
                        //console.log(this.dataToko);
                    } else {
                        //this.snackbar = true;
                        //this.snackbarMessage = data.message;
                        this.dataToko = data.data;
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err);
                    this.loading1 = false;
                    var error = err.response
                    if (error.data.expired == true) {
                        this.snackbar = true;
                        this.snackbarMessage = error.data.message;
                        setTimeout(() => window.location.href = error.data.data.url, 1000);
                    }
                })
        },
    }
</script>
<?php $this->endSection("js") ?>