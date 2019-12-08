import axios from 'axios'

export const post = ({ url }) => {
    // return axios.post(`${process.env.API_URL}`, { url })
    return axios.post(`/${routes.post_short_route}` || '/short', { url })
}
