<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>Menu</h1>
          <h2>Daftar Menu</h2>
        </div>
        <div class="button-container">
          <router-link class="button" to="/admin/menu/add"> Add Menu </router-link>
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Nama</td>
              <td>Jenis</td>
              <td>Deskripsi</td>
              <td>Gambar</td>
              <td>Harga</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="menu in menus" :key="menu.id_menu">
              <td>{{ menu.nama_menu }}</td>
              <td>{{ menu.jenis }}</td>
              <td>{{ menu.deskripsi }}</td>
              <td>
                <img :src="`/storage/${menu.gambar}`" />
              </td>
              <td>Rp. {{ menu.harga.toLocaleString("id-ID") }}</td>
              <td>
                <router-link class="button-edit" :to="{ name: 'editMenu', params: { id: menu.id_menu }}"> Edit </router-link>
                <button
                  class="button-delete"
                  @click="deleteMenuItem(menu.id_menu)"
                >
                  Delete
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
import { getAllMenu, deleteMenu } from "@/stores/menu";

import Header from "../Header.vue";

export default {
  components: {
    Header,
  },

  name: "ListMenu",

  data() {
    return {
      menus: [],
    };
  },

  methods: {
    async fetchMenu() {
      try {
        const store = await getAllMenu();
        const data = await store.authenticate("admin/food/get");
        console.log("Fetched data:", data);
        this.menus = data;
      } catch (error) {
        console.log(error);
      }
    },

    async deleteMenuItem($idMenu) {
      try {
        const store = await deleteMenu();
        await store.authenticate(`admin/food/delete/${$idMenu}`);
        this.fetchMenu();
      } catch (error) {
        console.log(error);
      }
    },
  },

  mounted() {
    this.fetchMenu();
  },
};
</script>

<style scoped>
.button {
  width: 150%;
}

img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 15vh;
  height: 15vh;
}
</style>