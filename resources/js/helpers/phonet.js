export default class {
    constructor(conf) {
        this.wc = new WebSocket(`wss://${conf.domain}/live/connector/v3/easy?domain=${conf.domain}&apiKey=${conf.apiKey}&subscriber=${conf.subscriber}`)
        
        this.callbacks = {}

        this.wc.onmessage = e => {
            const data = JSON.parse(e.data)

            if (data.lgDirection == 4) {
                this.callbacks[data.event]?.forEach(callback => callback(data))
            }
        }
    }

    listen(event, callback) {
        if (this.callbacks[event]) {
            this.callbacks[event].push(callback)
        } else {
            this.callbacks[event] = [callback]
        }
    }
}