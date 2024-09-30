<template>
  <Header />
  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <div class="title-container">
          <h1>History</h1>
          <h2>All Orders History</h2>
        </div>
        <div class="button-container">
          <router-link class="button">Add order</router-link>
        </div>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <td>Tanggal</td>
              <td>Pelanggan</td>
              <td>Meja</td>
              <td>Status Transaksi</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td>{{ order.tanggal_transaksi }}</td>
              <td>{{ order.nama_pelanggan }}</td>
              <td>{{ order.detail_meja.nomor_meja }}</td>
              <td>{{ order.status }}</td>
              <td>
                <!-- Add action buttons or links here -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted } from "vue";
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
    };
  },
  methods: {
    async fetchOrders() {
      try {
        const store = await getAllOrders();
        const data = await store.authenticate("kasir/transaksi/get");
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

.header-container {
  justify-content: space-between;
  align-self: flex-start;
  margin-bottom: 20px;
  display: flex;
  width: 100%;
  align-items: center;
}

.wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
  background-color: #fff8e8;
  padding-bottom: 10vh;
  overflow: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.card {
  width: 80%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-top: 50px;
  padding-bottom: 50px;
}

td {
  padding-top: 30px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgb(218, 218, 218);
}

</style>

