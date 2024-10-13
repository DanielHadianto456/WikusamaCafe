<template>
  <Header />

  <div class="wrapper">
    <div class="card">
      <div class="header-container">
        <h1>Add Meja</h1>
      </div>
    </div>
    <div class="card">
      <div class="table-container">
        <form @submit.prevent="addMeja">
          <table class="table-list">
            <thead></thead>
            <tbody>
              <tr>
                <td>Nomor Meja</td>
              </tr>
              <tr>
                <td>
                  <input type="text" v-model="formData.nomor_meja" required />
                </td>
              </tr>
              <tr>
                <td>
                  <button class="button">Tambah Meja</button>
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
import { addMeja } from "@/stores/meja";

export default {
  components: {
    Header,
  },
  name: "TambahMeja",

  data() {
    return {
      formData: {
        nomor_meja: "",
      },
    };
  },

  methods: {
    async addMeja(){
        try{
            const store = addMeja();
            await store.authenticate("admin/meja/add", this.formData);
        } catch(error){
            console.log(error);
        }
    }
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