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
                  <input type="text" v-model="formData.nama_menu"  />
                </td>
              </tr>
              <tr>
                <td>Jenis</td>
              </tr>
              <tr>
                <td>
                  <select name="jenis"  v-model="formData.jenis">
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
                    <input type="text" v-model="formData.deskripsi"  />
                </td>
              </tr>
              
              <tr>
                <td>
                    Harga
                </td>
              </tr>
              <tr>
                <td>
                    <input type="number" v-model="formData.harga"  />
                </td>
              </tr>
              <tr>
                <td>
                    Gambar
                </td>
              </tr>
              <tr>
                <td>
                    <input type="file" @change="handleFileChange" style="border-bottom: 0px;" />
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

#gambar{
  border-bottom: 0px;
}

</style>