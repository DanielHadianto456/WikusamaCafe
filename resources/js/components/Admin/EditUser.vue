<template>
  <Header />

  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Edit Data</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="update">
          <table class="table-list">
            <thead></thead>
            <tbody>
              <tr>
                <td>Nama User</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.nama_user" required />
                </td>
              </tr>
              <tr>
                <td>Username</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.username" required />
                </td>
              </tr>
              <tr>
                <td>Role</td>
              </tr>
              <tr>
                <td>
                   <select name="role" required v-model="formData.role">
                    <option value="ADMIN">Admin</option>
                    <option value="MANAJER">Manajer</option>
                    <option value="KASIR">Kasir</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <button class="button">Edit Data</button>
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
import { editUsers } from "@/stores/user";

export default {
  components: {
    Header,
  },
  name: "UpdateUser",

  data() {
    return {
      formData: {
        nama_user: "",
        role: "",
        username: "",
      },
    };
  },

  methods: {
    async update() {
      try {
        const formData = new FormData();
        formData.append("nama_user", this.formData.nama_user);
        formData.append("username", this.formData.username);
        formData.append("role", this.formData.role);
        const store = editUsers();
        await store.authenticate(`admin/user/update/${this.$route.params.id}`, formData);
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style scoped>

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