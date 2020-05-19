import axios from 'axios'

export default {
    GET_USERS_FROM_API ({commit}) {
        return axios('http://messenger.test/api/users', {
            method: 'GET'
        })
        .then ((users) => {
            commit('SET_USERS_TO_STATE', users.data);
            return users;
        })
        .catch((error) => {
            console.log(error);
            return error;
        })
    },
}