<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>History</h1>
          <h2>All Orders History</h2>
        </div>
        <div class="date-filter">
          <label for="filter-date">Filter Date:</label>
          <input type="date" v-model="filterDate" id="filter-date" />
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Tanggal</td>
              <td>Kasir</td>
              <td>Pelanggan</td>
              <td>Nomor Meja</td>
              <td>Status Transaksi</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in filteredOrders" :key="order.id_transaksi">
              <td>{{ order.tanggal_transaksi }}</td>
              <td>{{ order.detail_pegawai.nama_user }}</td>
              <td>{{ order.nama_pelanggan }}</td>
              <td>{{ order.detail_meja.nomor_meja }}</td>
              <td
                v-if="order.status === 'BELUM_BAYAR'"
                style="color: #be0000; font-weight: bold"
              >
                BELUM BAYAR
              </td>
              <td v-else style="color: green; font-weight: bold">LUNAS</td>
              <td>
                <router-link
                  class="button"
                  :to="{
                    name: 'manajerDetail',
                    params: { id: order.id_transaksi },
                  }"
                >
                  Detail
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { getAllOrders } from "@/stores/orders";
import Header from "../Header.vue";

export default {
  components: {
    Header,
  },
  name: "History",
  data() {
    return {
      orders: [],
      filterDate: "",
    };
  },
  computed: {
    filteredOrders() {
      if (!this.filterDate) {
        return this.orders;
      }
      const filterDate = new Date(this.filterDate).toISOString().split("T")[0];
      return this.orders.filter((order) => {
        const transactionDate = new Date(order.tanggal_transaksi)
          .toISOString()
          .split("T")[0];
        return transactionDate === filterDate;
      });
    },
  },
  methods: {
    async fetchOrders() {
      try {
        const store = await getAllOrders();
        const data = await store.authenticate("manajer/transaksi/get");
        console.log("Fetched data:", data);
        this.orders = data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  mounted() {
    this.fetchOrders();
  },
};
</script>

<style scoped>
.button {
  width: 150px;
}

.button-done {
  width: 150px;
}

td {
  padding-top: 30px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgb(218, 218, 218);
  color: black;
}

.date-filter {
  font-weight: bold;
  margin-bottom: 20px;
}

.date-filter label {
  margin-right: 10px;
}

.date-filter input {
  margin-right: 20px;
}
</style>