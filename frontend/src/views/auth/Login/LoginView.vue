<template>
  <div class="container mt-5">
    <div class="row d-flex justify-content-center">
      <div class="col-md-6">
        <div class="card px-5 py-5" id="form1">
          <div class="form-data">
            <div class="forms-inputs mb-4">
              <span>Email or username</span>
              <input
                autocomplete="off"
                type="text"
                v-model="formData.email"
                v-bind:class="{
                  'form-control': true,
                  'is-invalid': !validEmail(formData.email) && emailBlured,
                }"
                v-on:blur="emailBlured = true"
              />
              <div class="text-danger" v-if="errors.email != ''">
                {{ errors.email[0] || "" }}
              </div>
              <div class="invalid-feedback">A valid email is required!</div>
            </div>
            <div class="forms-inputs mb-4">
              <span>Password</span>
              <input
                autocomplete="off"
                type="password"
                v-model="formData.password"
                v-bind:class="{
                  'form-control': true,
                  'is-invalid':
                    !validPassword(formData.password) && passwordBlured,
                }"
                v-on:blur="passwordBlured = true"
              />
              <div class="invalid-feedback">Password must be 6 character!</div>
              <div class="text-danger" v-if="errors.password != ''">
                {{ errors.password[0] || "" }}
              </div>
            </div>
            <div class="mb-3">
              <button
                v-on:click.stop.prevent="submit"
                class="btn btn-dark w-100"
              >
                <span v-if="loading"> Carregando ...</span>
                <span v-else>Login</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data: () => ({
    emailBlured: false,
    valid: false,
    passwordBlured: false,
    loading: false,
    formData: {
      email: "",
      password: "",
    },
    errors: {
      email: "",
      password: "",
    },
  }),
  computed: {},
  methods: {
    ...mapActions(["login", "getMe"]),

    validate() {
      this.emailBlured = true;
      this.passwordBlured = true;
      if (
        this.validEmail(this.formData.email) &&
        this.validPassword(this.formData.password)
      ) {
        this.valid = true;
      }
    },
    validEmail(email) {
      var re = /(.+)@(.+){2,}\.(.+){2,}/;
      if (re.test(email.toLowerCase())) {
        return true;
      }
    },
    validPassword(password) {
      if (password.length >= 6) {
        return true;
      }
    },
    submit() {
      this.validate();
      if (this.valid) this.auth();
    },
    auth() {
      this.reset();
      this.loading = true;
      this.login(this.formData)
        .then(() => {
          // this.getMe();
          console.log("aqui");
          return this.$router.push("/kanban");
        })
        .catch((error) => {
          const errorResponse = error.response;

          console.log(error);

          if (errorResponse.status === 422) {
            this.errors = Object.assign(this.errors, errorResponse.data.errors);
            return alert("Dados inválidos, verifique novamente");
          }

          alert("Falha na operação", "Erro");
          setTimeout(() => this.reset(), 4000);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    reset() {
      this.errors = { email: "", password: "" };
    },
  },
};
</script>

<style scoped>
body {
  background: #000;
}

.card {
  border: none;
  height: 320px;
}

.forms-inputs {
  position: relative;
}

.forms-inputs span {
  position: absolute;
  top: -18px;
  left: 10px;
  background-color: #fff;
  padding: 5px 10px;
  font-size: 15px;
}

.forms-inputs input {
  height: 50px;
  border: 2px solid #eee;
}

.forms-inputs input:focus {
  box-shadow: none;
  outline: none;
  border: 2px solid #000;
}

.btn {
  height: 50px;
}

.success-data {
  display: flex;
  flex-direction: column;
}

.bxs-badge-check {
  font-size: 90px;
}
</style>