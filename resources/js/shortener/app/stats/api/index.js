import axios from 'axios'

export const get = ({ code }) => {
    // return axios.get(`${process.env.API_URL}/stats?code=${code}`)
    return axios.get(`/${routes.get_stats_route}?code=${code}` || `/stats?code=${code}`)
}
