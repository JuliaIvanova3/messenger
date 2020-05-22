import Vue from 'vue'
import Vuex from 'vuex'

import commonAcions from './actions/actions'
import apiRequest from './actions/api-request'
import mutations from './mutations/mutations'
import getters from './getters/getters'

const actions = {...commonAcions, ...apiRequest}

Vue.use(Vuex)

let store = new Vuex.Store({
    state: {
        users: [],
        chats: [],
        currentChat: '',
        messages: [],
        members: [],
        notUsers: []
    },
    mutations,
    actions,
    getters
});

export default store;