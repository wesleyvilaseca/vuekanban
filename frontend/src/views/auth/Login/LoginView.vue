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
                  'is-invalid': !validPassword(formData.password) && passwordBlured,
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
import "./style.css";

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
        .then((res) => {
          console.log(res);
          this.getMe();
        })
        .catch((error) => {
          const errorResponse = error.response;
          if (errorResponse.status === 422) {
            this.errors = Object.assign(this.errors, errorResponse.data.errors);
            this.$vToastify.error(
              "Dados inválidos, verifique novamente",
              "Erro"
            );
            return;
          }
          this.$vToastify.error("Falha na operação", "Erro");
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