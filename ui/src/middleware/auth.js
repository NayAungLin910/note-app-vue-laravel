export const ifAuth = (to, from, next) => {
    const data = localStorage.getItem('auth');
    if(data !== "null"){
        const user = JSON.parse(data).user;
        return next({
            name: 'index',
            params: {
                message: JSON.stringify({
                    type:"i",
                    message:`You already logined as ${user.name} !`,
                })
            }
        })
    }
    return next();
}

export const ifNotAuth = (to, from, next) => {
    const data = localStorage.getItem('auth');

    if(data == "null"){
        return next({
            name: 'login',
            params: {
                message: JSON.stringify({
                    type:"e",
                    message:`Please login first !`,
                })
            }
        })
    }
    return next();
}