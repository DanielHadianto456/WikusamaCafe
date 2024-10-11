<template>
  <Header />
  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Add an Order</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="submitOrder">
          <table class="table-list">
            <thead></thead>
            <tbody>
              <tr>
                <td>Nama Pelanggan</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.nama_pelanggan" />
                </td>
              </tr>
              <tr>
                <td>Nomor Meja</td>
              </tr>
              <tr>
                <td>
                  <select name="" id="" v-model="formData.id_meja">
                    <option
                      v-for="table in tables"
                      :key="table.id_meja"
                      :value="table.id_meja"
                    >
                      {{ table.nomor_meja }}
                    </option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <button class="button">Tambah Pesanan</button>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Header from "../Header.vue";
import { getAllTables, addOrder } from "@/stores/orders";

export default {
  components: {
    Header,
  },
  name: "Tambah",

  data() {
    return {
      tables: [],
      formData: {
        nama_pelanggan: "",
        id_meja: "",
      },
    };
  },

  methods: {
    async fetchTables() {
      try {
        const store = getAllTables();
        const tables = await store.authenticate("kasir/meja/getKosong");
        console.log("Fetched data:", tables);
        this.tables = tables;
      } catch (error) {
        console.log(error);
      }
    },

    async submitOrder() {
      try {
        const store = addOrder();
        await store.authenticate("kasir/transaksi/add", this.formData);
      } catch (error) {
        console.log(error);
      }
    },
  },

  mounted() {
    this.fetchTables();
  },
};
</script>

<style scoped>
.card {
  width: 80%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-top: 50px;
  padding-bottom: 50px;
}

.header-container {
  justify-content: space-between;
  align-self: flex-start;
  display: flex;
  width: 100%;
  align-items: center;
}
/* 
table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
} */

input {
  font-family: "poppins";
  border: 0;
  outline: none;
  border-bottom: 2px solid;
  position: relative;
  width: 40%;
  height: 7.5vh;
  padding: 1vh 2vh;
  font-size: 2vh;
  background: none;
}

td {
  border-bottom: 0px;
}

select {
  font-family: "poppins";
  border: 0;
  outline: none;
  border-bottom: 2px solid;
  position: relative;
  width: 43%;
  height: 7.5vh;
  padding: 1vh 2vh;
  font-size: 2vh;
  background: none;
}
</style>