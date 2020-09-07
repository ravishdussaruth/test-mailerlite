import axios from 'axios';

export const state = {
  accessToken: null,
  account: null,
  accountId: null
};

export const mutations = {
  /**
   * Save the access token for future use.
   * @param state
   * @param token
   */
  SET_TOKEN: (state, token) => state.accessToken = token,

  /**
   * Set account selected.
   *
   * @param state
   * @param account
   */
  SET_ACCOUNT: (state, account) => state.account = account,

  /**
   * Set the account id.
   *
   * @param state
   * @param id
   */
  SET_ACCOUNT_ID: (state, id) => state.accountId = id
};

export const actions = {
  /**
   * Fetch the api token.
   *
   * @param commit
   * @param clientId
   * @param clientSecret
   */
  FETCH_TOKEN: async ({commit}, {clientId, clientSecret}) => {
    let {data: {token_type, access_token}} = await axios.post('http://localhost/oauth/token', {
        'grant_type': 'client_credentials',
        'client_id': clientId,
        'client_secret': clientSecret
      }, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      }
    );

    commit('SET_TOKEN', token_type + ' ' + access_token);
  },

  /**
   * Fetch account details.
   *
   * @param commit
   * @param accountId
   */
  FETCH_ACCOUNT: async ({commit, state}, accountId) => {
    let {data: {data}} = await axios.get('http://localhost/api/accounts/' + accountId, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'Authorization': state.accessToken
        }
      }
    ).catch(err => {
      commit('SET_TOKEN', null)
    });

    commit('SET_ACCOUNT', data);
  }
};
