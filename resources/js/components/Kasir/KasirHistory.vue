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
          <router-link to="/kasir/kasirTambah" class="button"
            >Add order</router-link
          >
        </div>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <td>Tanggal</td>
              <td>Pelanggan</td>
              <td>Nomor Meja</td>
              <td>Status Transaksi</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td>{{ order.tanggal_transaksi }}</td>
              <td>{{ order.nama_pelanggan }}</td>
              <td>{{ order.detail_meja.nomor_meja }}</td>
              <td
                v-if="order.status === 'BELUM_BAYAR'"
                style="color: red; font-weight: bold"
              >
                BELUM BAYAR
              </td>
              <td v-else style="color: green; font-weight: bold">LUNAS</td>
              <td>
                <button
                  class="button"
                  v-if="order.status === 'BELUM_BAYAR'"
                  @click="payOrders(order.id_transaksi)"
                >
                  Bayar
                </button>
                <button class="button button-done" disabled v-else>
                  Sudah lunas
                </button>
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
import { getAllOrders, payOrder } from "@/stores/orders";

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

    async payOrders(orderId) {
      try {
        const store = await payOrder();
        await store.authenticate(`kasir/transaksi/update/${orderId}`);
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

.button-done {
  background-color: #f0f0f0;
  color: #a0a0a0;
  cursor: default;
}
</style>

