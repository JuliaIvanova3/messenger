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
    GET_CHATS_FROM_API({commit}) {
        return axios('http://messenger.test/api/getchat', {
            method: 'GET'
        })
        .then ((chats) => {
            commit('SET_CHATS_TO_STATE', chats.data);
            return chats;
        })
        .catch ((error) => {
            console.log(error);
            return error;
        })
    },
    GET_MESSAGES_FROM_API ({commit}) {
        if (this.state.currentChat == '') {
            let messages = []
            commit('SET_MESSAGES_TO_STATE', messages);
        } else {
            let chat = this.state.currentChat;
            return axios.post('http://messenger.test/api/getmsgbychat', {
                chat_id: chat
            })
            .then ((messages) => {
                commit('SET_MESSAGES_TO_STATE',messages.data);
                return messages;
            })
            .catch ((error) => {
                console.log(error);
                return error;
            })
        }
    },
    GET_MEMBERS_FROM_API ({commit}) {
        if (this.state.currentChat == '') {
            let members = []
            commit('SET_MEMBERS_TO_STATE', members);
        } else {
            return axios.post('http://messenger.test/api/getByChat/'+this.state.currentChat.id)
            .then((members)=> {
               commit('SET_MEMBERS_TO_STATE', members.data);
               return members;
            })
            .catch ((error) => {
                console.log(error);
                return error;
            })
        }
    },
    GET_NOT_USERS_FROM_API ({commit}) {
        if (this.state.currentChat == '') {
            let vm = []
            commit('SET_NOT_USERS_TO_STATE', vm);
        } else {
            return axios.post('http://messenger.test/api/getUsers/'+this.state.currentChat.id)
            .then ((users) => {
                commit('SET_NOT_USERS_TO_STATE', users.data);
                return users;
            })
            .catch ((error) => {
                console.log(error);
                return error;
            })
        }
    }
}