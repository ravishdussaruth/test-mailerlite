<template>
  <div class="container" v-if="loading">Loading...</div>

  <div v-else>
    <b-card :header="'Welcome, ' + account.name" class="mt-3">
      <b-card-text>
        <div>
          Account: <code>{{ account.id }}</code>
        </div>
        <div>
          Balance:
          <code>{{ account.currency === "usd" ? "$" : "€" }}{{ account.balance }}</code>
        </div>
        <div>
          Daily Limit:
          <code>{{ account.currency === "usd" ? "$" : "€" }}{{ account.limit }}</code>
        </div>
        <div>
          Spent:
          <code>{{ account.currency === "usd" ? "$" : "€" }}{{ account.spent }}</code>
        </div>
      </b-card-text>
      <b-button size="sm" variant="success" @click="show = !show">
        New payment
      </b-button>

      <b-button class="float-right"
                variant="danger"
                size="sm"
                nuxt-link
                @click="logout">
        Logout
      </b-button>
    </b-card>
    <div class="container">

      <b-card class="mt-3" header="New Payment" v-show="show">
        <b-form @submit="onSubmit">
          <b-form-group id="input-group-1" label="To:" label-for="input-1">
            <b-form-input
              id="input-1"
              size="sm"
              v-model="payment.to"
              type="number"
              required
              placeholder="Destination ID"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
            <b-input-group prepend="$" size="sm">
              <b-form-input
                id="input-2"
                v-model="payment.amount"
                type="number"
                required
                placeholder="Amount"
              ></b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group id="input-group-3" label="Details:" label-for="input-3">
            <b-form-input
              id="input-3"
              size="sm"
              v-model="payment.details"
              required
              placeholder="Payment details"
            ></b-form-input>
          </b-form-group>

          <b-button type="submit" size="sm" variant="primary">Submit</b-button>
        </b-form>
      </b-card>

      <b-card class="mt-3" header="Payment History">
        <b-table striped hover :items="transactions"></b-table>
      </b-card>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        show: false,
        payment: {},
        account: {},
        transactions: null,
        loading: true,
        accountLoaded: false,
      };
    },

    watch: {
      '$route.params.id'() {
        this.getAccountDetails();
      }
    },

    methods: {
      /**
       * Get user account details.
       *
       * @return {Promise<void>}
       */
      async getAccountDetails() {
        this.accountLoaded = true;

        await this.$store.dispatch('token/FETCH_ACCOUNT', this.$route.params.id)
          .catch(err => {
            window.location = '/'
          });

        this.account = this.$store.state.token.account;
        this.accountLoaded = false;
      },

      /**
       * Get accounts transactions.
       *
       * @return {Promise<void>}
       */
      async getTransactions() {
        let {data: {data}} = await axios.get(`http://localhost/api/accounts/${ this.$route.params.id }/transactions`);

        this.transactions = data;
      },

      /**
       * Send data to create new payment.
       *
       * @param evt
       */
      onSubmit(evt) {
        evt.preventDefault();

        axios.post(`http://localhost/api/accounts/${ this.$route.params.id }/transactions`, this.payment, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': this.$store.state.token.accessToken
          }
        }).catch(err => {
          this.$bvToast.toast(err.response.error, {
            title: err.response.title,
            variant: 'danger',
            solid: true
          })
        });

        this.payment = {};
        this.show = false;

        // update items
        setTimeout(() => {
          this.getAccountDetails();
          this.getTransactions();
        }, 200);
      },

      /**
       * Log the user out.
       */
      async logout() {
        this.$store.commit('token/SET_TOKEN', null);

        window.location = '/'
      }
    },

    mounted() {
      this.loading = true;
      this.getAccountDetails();
      this.getTransactions();
      this.loading = false;
    },
  };
</script>
