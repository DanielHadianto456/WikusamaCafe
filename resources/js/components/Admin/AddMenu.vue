<template>
  <Header />

  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Add Menu</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="addMenu">
          <table class="table-list">
            <thead></thead>
            <tbody>
              <tr>
                <td>Nama Menu</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.nama_menu" required />
                </td>
              </tr>
              <tr>
                <td>Jenis</td>
              </tr>
              <tr>
                <td>
                  <select name="jenis" required v-model="formData.jenis">
                    <option value="MAKANAN">Makanan</option>
                    <option value="MINUMAN">Minuman</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                    Deskripsi
                </td>
              </tr>
              <tr>
                <td>
                    <input type="text" v-model="formData.deskripsi" required />
                </td>
              </tr>
              <tr>
                <td>
                    Gambar
                </td>
              </tr>
              <tr>
                <td>
                    <input type="file" @change="handleFileChange" required />
                </td>
              </tr>
              <tr>
                <td>
                    Harga
                </td>
              </tr>
              <tr>
                <td>
                    <input type="number" v-model="formData.harga" required />
                </td>
              </tr>
              <tr>
                <td>
                  <button class="button">Tambah Menu</button>
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
import { addMenu } from "@/stores/menu";

export default {
  components: {
    Header,
  },
  name: "Tambah",

  data() {
    return {
      formData: {
        nama_menu: "",
        jenis: "",
        deskripsi: "",
        harga: "",
      },
      file: null,
    };
  },

  methods: {
    handleFileChange(event) {
      this.file = event.target.files[0];
    },
    async addMenu() {
      try {
        const formData = new FormData();
        formData.append("nama_menu", this.formData.nama_menu);
        formData.append("jenis", this.formData.jenis);
        formData.append("deskripsi", this.formData.deskripsi);
        formData.append("harga", this.formData.harga);
        if (this.file) {
          formData.append("gambar", this.file);
        }

        const store = addMenu();
        await store.authenticate("admin/food/add", formData);
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