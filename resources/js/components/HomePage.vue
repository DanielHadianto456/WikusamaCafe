<template>
  <Header />
  <div class="wrapper" v-if="role === 'KASIR'">
    <div class="card">
      <h1>Welcome to Cashier Panel</h1>
    </div>
    <div class="card buttons-container">
      <router-link to="/kasir/kasirHistory" class="button">
        <strong> History </strong>
      </router-link>
      <router-link to="/kasir/kasirTambah" class="button">
        <strong> Tambah Pesanan </strong>
      </router-link>
    </div>
  </div>
  <div class="wrapper" v-else-if="role === 'MANAJER'">
    <div class="card">
      <h1>Welcome to Manajer Panel</h1>
    </div>
    <div class="card buttons-container">
      <router-link to="/Manajer/manajerHistory" class="button">
        <strong> History </strong>
      </router-link>
    </div>
  </div>
  <div class="wrapper" v-else-if="role === 'ADMIN'">
    <div class="card">
      <h1>Welcome to Admin Panel</h1>
    </div>
    <div class="card buttons-container">
      <router-link to="/admin/menu" class="button">
        <strong> Menu </strong>
      </router-link>
      <router-link to="/admin/meja" class="button">
        <strong> Meja </strong>
      </router-link>
      <router-link to="/admin/user" class="button">
        <strong> Users </strong>
      </router-link>
    </div>
  </div>
</template>

<script>
import Header from "./Header.vue";
import { jwtDecode } from "jwt-decode";

export default {
  components: {
    Header,
  },
  name: "Home",

  data() {

    let username = null;
    let role = null;
    const token = localStorage.getItem('token');

    if (token) {
      const decodedToken = jwtDecode(token);
      username = decodedToken.username;
      role = decodedToken.role;
    }

    return {
      // role: localStorage.getItem("role"),
      username,
      role,
    };
  },
};
</script>

<style scoped>
.wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
  /* background-color: #fff8e8; */
}

.buttons-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 5vh;
}
</style>
