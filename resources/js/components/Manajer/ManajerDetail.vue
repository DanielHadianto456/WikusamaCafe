<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>Order Detail</h1>
          <h2>Current Items</h2>
        </div>
        <div class="button-container"></div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Nama Menu</td>
              <td>Jenis</td>
              <td>Harga</td>
              <td>Gambar</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="detail in orderDetails" :key="detail.id">
              <td>{{ detail.detail_menu.nama_menu }}</td>
              <td>{{ detail.detail_menu.jenis }}</td>
              <td>
                Rp. {{ detail.detail_menu.harga.toLocaleString("id-ID") }}
              </td>
              <td>
                <img :src="`/storage/${detail.detail_menu.gambar}`" />
              </td>
            </tr>
            <tr>
              <td>
                <h3>Total: Rp. {{ totalHarga.toLocaleString("id-ID") }}</h3>
              </td>
              <td></td>
              <td></td>
              <td>
                <button
                  v-if="orderStatus.status === 'LUNAS'"
                  class="button-done"
                >
                  Sudah Lunas
                </button>
                <router-link :to="{ name: 'manajerHistory' }" class="button"
                  >Kembali</router-link
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { getOrderDetail, getOrderId } from "@/stores/orders";

import Header from "../Header.vue";

export default {
  components: {
    Header,
  },
  name: "kasirDetail",
  data() {
    return {
      orderDetails: [],
      orderStatus: [],
    };
  },

  methods: {
    async fetchOrderDetail() {
      try {
        const store = await getOrderDetail();
        const data = await store.authenticate(
          `manajer/transaksi/detail/DetailTransaksiId/${this.$route.params.id}`
        );
        console.log("Fetched data:", data);
        this.orderDetails = data;
      } catch (error) {
        console.log(error);
      }
    },

    async fetchOrderId() {
      try {
        const store = await getOrderId();
        const data = await store.authenticate(
          `manajer/transaksi/getId/${this.$route.params.id}`
        );
        console.log("Fetched data:", data);
        this.orderStatus = data;
      } catch (error) {
        console.log(error);
      }
    },
  },

  computed: {
    totalHarga() {
      return this.orderDetails.reduce((sum, detail) => {
        return sum + detail.detail_menu.harga;
      }, 0);
    },
  },

  mounted() {
    this.fetchOrderDetail();
    this.fetchOrderId();
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
}

img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 15vh;
  height: 15vh;
}
</style>