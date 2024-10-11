<template>
  <Header />

  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Edit Menu</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="update">
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
import { editMenu } from "@/stores/menu";

export default {
  components: {
    Header,
  },
  name: "Update",

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
    async update() {
      try {
        const formData = new FormData();
        formData.append("nama_menu", this.formData.nama_menu);
        formData.append("jenis", this.formData.jenis);
        formData.append("deskripsi", this.formData.deskripsi);
        formData.append("harga", this.formData.harga);
        if (this.file) {
          formData.append("gambar", this.file);
        }

        const store = editMenu();
        await store.authenticate(`admin/food/update/${this.$route.params.id}`, formData);
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>