<template>
  <Header />
  <div class="wrapper">
    <div class="card">
      <h1>Welcome to Cashier Panel</h1>
    </div>
    <div class="card buttons-container">
      <router-link to="/kasir/kasirHistory" class="button">
        <strong>
          History
        </strong>
      </router-link>
      <router-link to="/kasir/penjualan" class="button">
        <strong>
          Tambah Pesanan
        </strong>
      </router-link>
      <router-link to="/kasir/penjualan" class="button">
        <strong>
          Cetak Nota
        </strong>
      </router-link>
    </div>
  </div>
</template>

<script>
import Header from "../Header.vue";

export default {
  components: {
    Header,
  },
  name: "Home",
};
</script>

<style scoped>
.wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
  background-color: #fff8e8;
}

.buttons-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center; 
  gap: 5vh; 
}


</style>
