<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
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
        <table class="table-list">
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
            <tr v-for="order in orders" :key="order.id_transaksi">
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
                <router-link class="button" :to="{ name: 'kasirDetail', params: { id: order.id_transaksi }}">
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

td {
  padding-top: 30px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgb(218, 218, 218);
}
</style>

