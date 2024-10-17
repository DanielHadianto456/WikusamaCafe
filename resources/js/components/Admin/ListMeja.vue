<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>Meja</h1>
          <h2>Daftar Meja</h2>
        </div>
        <div class="button-container">
          <router-link class="button" to="/admin/meja/add">
            Add Meja
          </router-link>
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Nomor</td>
              <td>Status</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="table in tables" :key="table.id_meja">
              <td>{{ table.nomor_meja }}</td>
              <td :class="{'status-kosong': table.status === 'KOSONG', 'status-occupied': table.status !== 'KOSONG'}">
                {{ table.status }}
              </td>
              <td>
                <router-link
                  class="button-edit"
                  :to="{ name: 'editMeja', params: { id: table.id_meja } }"
                >
                  Edit
                </router-link>
                <button
                  class="button-delete"
                  @click="deleteTable(table.id_meja)"
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
import { getAllMeja, deleteMeja } from "@/stores/meja";

import Header from "../Header.vue";

export default {
  components: {
    Header,
  },

  name: "ListMeja",

  data() {
    return {
      tables: [],
    };
  },

  methods: {
    async fetchMeja() {
      try {
        const store = await getAllMeja();
        const data = await store.authenticate("admin/meja/get");
        console.log("Fetched data:", data);
        this.tables = data;
      } catch (error) {
        console.log(error);
      }
    },

    async deleteTable($idMeja) {
      try {
        const store = await deleteMeja();
        await store.authenticate(`admin/meja/delete/${$idMeja}`);
        this.fetchMeja();
      } catch (error) {
        console.log(error);
      }
    },
  },

  mounted() {
    this.fetchMeja();
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