<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>Users</h1>
          <h2>Daftar User</h2>
        </div>
        <div class="button-container">
          <router-link class="button" to="/admin/user/add"> Add User </router-link>
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Nama User</td>
              <td>Role</td>
              <td>Username</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id_user">
                <td>{{ user.nama_user }}</td>
                <td>{{ user.role }}</td>
                <td>{{ user.username }}</td>
                <td>
                    <router-link class="button-edit" :to="{ name: 'editUser', params: { id: user.id_user }}">
                        Edit
                    </router-link>
                    <button class="button-delete" @click="deleteUser(user.id_user)">
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
import { getAllUsers, deleteUser } from "@/stores/user";

import Header from "../Header.vue";

export default {
  components: {
    Header,
  },

  name: "ListUser",

  data() {
    return {
      users: [],
    };
  },

  methods: {
    async fetchUser() {
      try {
        const store = await getAllUsers();
        const data = await store.authenticate("admin/user/get");
        console.log("Fetched data:", data);
        this.users = data;
      } catch (error) {
        console.log(error);
      }
    },

    async deleteUser($idUser) {
      try {
        const store = await deleteUser();
        await store.authenticate(`admin/user/delete/${$idUser}`);
        this.fetchUser();
      } catch (error) {
        console.log(error);
      }
    },

    // async deleteTable($idMeja) {
    //   try {
    //     const store = await deleteMeja();
    //     await store.authenticate(`admin/meja/delete/${$idMeja}`);
    //   } catch (error) {
    //     console.log(error);
    //   }
    // },
  },

  mounted() {
    this.fetchUser();
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

.status-kosong {
  color: green;
  font-weight: bold;
}

.status-occupied {
  color: #BE0000;
  font-weight: bold;
}
</style>