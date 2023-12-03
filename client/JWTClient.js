// export JwtClient object


export class JWTClient {
    static SESSION_CREATED_AT =  '__jwtc__iat';
    static SESSION_DURATION =  '__jwtc__duration';

    #origin;
    #loginPath;
    #refreshPath;
    #accessToken;

    constructor(origin, loginPath, refreshPath) {
        this.#origin = origin;
        this.#loginPath = loginPath;
        this.#refreshPath = refreshPath;
        this.#accessToken = null;
    }

    async login(username, password) {
        let success = false;

        const url = this.#origin + this.#loginPath;

        await fetch(url, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Authorization': 'Basic ' + btoa(username + ":" + password)
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.authorized) {
                    success = true;
                    this.#accessToken = data.accessToken;
                    this.setCookie(this.createdAtKey(), Date.now(), {expires: new Date(data.hardDuration + Date.now())});
                    this.setCookie(this.durationKey(), data.hardDuration, {expires: new Date(data.hardDuration + Date.now())});
                }
            })
            .catch(err => {
                console.log(err);
            })
            .finally();

        return success;
    }

    async refreshAccessToken()  {
        console.log("REFRESHING ACCESS TOKEN...");
        let success = false;

        const url = this.#origin + this.#refreshPath;

        await fetch(url, {
            method: 'POST',
            credentials: 'include'
        })
            .then(response => response.json())
            .then(data => {
                console.log("REFRESHED ACCESS TOKEN: " + "Fetching data...")
                if (data.authorized) {
                    success = true;
                    this.#accessToken = data.accessToken;
                    console.log("REFRESHED ACCESS TOKEN: Successfully");
                }
            })
            .catch(err => {
                console.log("REFRESHED ACCESS TOKEN: Failed");
                console.log(err);
            })
            .finally();

        return success;
    }

    async fetch(path, options = {}) {
        let success = false;

        const url = this.#origin + path;

        // add Authorization header to options
        options.headers = options.headers || {};

        options.headers['Authorization'] = 'Bearer ' + this.#accessToken;

        let response = await fetch(url, options);

        if (response.status === 401) {
            success = await this.refreshAccessToken();
            if (success) {
                options.headers['Authorization'] = 'Bearer ' + this.#accessToken;
                response = await fetch(url, options);
            }
        }

        return response;
    }

    async fetchJson(url, options = {}) {
        return this.fetch(url, options).then(response => response.json());
    }

    stillHasTokenAfter(seconds) {
        let createdAt = parseInt(this.getCookie(this.createdAtKey()));
        let duration = parseInt(this.getCookie(this.durationKey()));

        console.log("Checking local token// CREATED AT: " + createdAt + "; DURATION: " + duration +
            "; NOW: " + Date.now() + "; REMAINING: " + (createdAt + duration - Date.now()));

        if (createdAt && duration) {
            return (createdAt + duration) > (Date.now() + seconds);
        }
        return false;
    }


    getCookie(name) {
        const cookies = document.cookie.split(';').map(cookie => cookie.trim());
        for (const cookie of cookies) {
            const [cookieName, cookieValue] = cookie.split('=');
            if (cookieName === name) {
                return cookieValue;
            }
        }
        return null;
    }

    setCookie(name, value, options = {}) {
        let cookieString = `${name}=${value}`;

        if (options.expires) {
            const expirationDate = new Date(options.expires).toUTCString();
            cookieString += `; expires=${expirationDate}`;
        }

        if (options.path) {
            cookieString += `; path=${options.path}`;
        }

        if (options.domain) {
            cookieString += `; domain=${options.domain}`;
        }

        if (options.secure) {
            cookieString += `; secure`;
        }

        if (options.httpOnly) {
            cookieString += `; HttpOnly`;
        }

        document.cookie = cookieString;
    }

    createdAtKey() {
        return JWTClient.SESSION_CREATED_AT + "_" + this.#origin;
    }

    durationKey() {
        return JWTClient.SESSION_DURATION + "_" + this.#origin;
    }
}

/************** EXPORT objects **************/
export const jwtClient = new JWTClient(
    "http://localhost:8001", "/auth/login", "/auth/refresh");