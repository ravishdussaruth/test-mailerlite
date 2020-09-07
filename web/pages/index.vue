<template>
  <div class="container">
    <div>
      <b-form @submit="validateAccount">
        <b-form-group id="input-group-2"
                      label="Enter your account id and credentials."
                      label-for="input-2">
          <b-form-input id="input"
                        type="number"
                        v-model="accountId"
                        required
                        placeholder="Account ID">
          </b-form-input>

          <b-form-input id="input"
                        type="number"
                        v-model="clientId"
                        class="mt-3"
                        required
                        placeholder="Client ID">
          </b-form-input>

          <b-form-input id="input"
                        v-model="secret"
                        class="mt-3"
                        required
                        placeholder="Client Key">
          </b-form-input>
        </b-form-group>

        <b-button nuxt-link
                  type="submit"
                  variant="primary">
          Login
        </b-button>
      </b-form>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    data() {
      return {
        accountId: 1,
        clientId: null,
        secret: null
      };
    },

    computed: {},

    methods: {
      /**
       * Get access token.
       *
       * @return {Object}
       */
      async fetchToken() {
        await this.$store.dispatch('token/FETCH_TOKEN', {clientId: this.clientId, clientSecret: this.secret})
      },

      /**
       * Validate account.
       *
       * @param evt
       * @return {Promise<void>}
       */
      async validateAccount(evt) {

        evt.preventDefault();
        await this.fetchToken();

        this.$store.commit('token/SET_ACCOUNT_ID', this.accountId);
        await this.$store.dispatch('token/FETCH_ACCOUNT', this.accountId).catch(err => console.log(err));

        this.$router.push({name: 'accounts-id', params: {id: this.accountId}})
      }
    },
  };
</script>

<style scoped>
  .container {
    margin: 0 auto;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
  }

  .title {
    font-family: "Quicksand", "Source Sans Pro", -apple-system, BlinkMacSystemFont,
    "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    display: block;
    font-weight: 300;
    font-size: 100px;
    color: #35495e;
    letter-spacing: 1px;
  }

  .subtitle {
    font-weight: 300;
    font-size: 42px;
    color: #526488;
    word-spacing: 5px;
    padding-bottom: 15px;
  }

  .links {
    padding-top: 15px;
  }
</style>
