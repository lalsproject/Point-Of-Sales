<v-data-table :headers="thBank" :items="dataBankWithIndex" :items-per-page="-1" :loading="loading">
    <template v-slot:item="{ item }">
        <tr>
            <td>{{dayjs(item.tanggal).format('DD-MM-YYYY')}}</td>
            <td>{{item.nama_toko}}</td>
            <td>{{item.nama_bank}}<br />{{item.no_rekening}}</td>
            <td>{{item.faktur}}</td>
            <td>{{RibuanLocale(item.pemasukan)}}</td>
            <td>{{RibuanLocale(item.pengeluaran)}}</td>
            <td>{{RibuanLocale( Number(item.pemasukan) - Number(item.pengeluaran) )}}</td>
            <td>
                <a link :href="'<?= base_url('biaya'); ?>?faktur=' + item.faktur" title="" alt="" v-if="item.id_biaya != null">
                    {{item.keterangan}}
                </a>

                <a link :href="'<?= base_url('penjualan'); ?>?faktur=' + item.faktur" title="" alt="" v-else-if="item.id_penjualan != null">
                    {{item.keterangan}}
                </a>

                <a link :href="'<?= base_url('pembelian'); ?>?faktur=' + item.faktur" title="" alt="" v-else-if="item.id_pembelian != null">
                    {{item.keterangan}}
                </a>
            </td>
        </tr>
    </template>
    <template slot="body.append">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Total</td>
            <td>{{ Ribuan(sumTotalBank('pemasukan')) }}</td>
            <td>{{ Ribuan(sumTotalBank('pengeluaran')) }}</td>
            <td>{{ RibuanLocale(sumTotalBank('pemasukan')-sumTotalBank('pengeluaran')) }}</td>
            <td></td>
        </tr>
    </template>
    <template v-slot:footer.prepend>
        <v-btn outlined :href="'<?= base_url('laporan/bank-pdf') ?>' + '?outlet=' + idToko + '&tgl_start=' + startDate + '&tgl_end=' + endDate" target="_blank" v-show="dataBank != ''">
            <v-icon>mdi-download</v-icon> PDF
        </v-btn>
    </template>
</v-data-table>
<!-- End Table -->