<template>
  <Header />
  <div class="wrapper">
    <div class="card">
      <h1>Welcome to Cashier Panel</h1>
    </div>
    <div class="card buttons-container">
      <router-link to="/kasir/penjualan" class="button">
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

.button {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-basis: 25%;
  height: 7.5vh;
  cursor: pointer;
  background-color: #071013;
  border: none;
  color: white;
  border-radius: 5vh;
  font-size: 2vh;
  text-decoration: none;
  font-family: "poppins";
  margin: 1vh; 
}

.buttons-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center; 
  gap: 5vh; 
}

.wrapper .card {
  margin-top: 7.5vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "poppins";
  background: white;
  border-radius: 10px;
  box-shadow: 5.5px 8px 8px #00000059;
  padding: 10vh 10vh 10vh 10vh;
  height: auto;
  width: 100vh;

}
</style>
