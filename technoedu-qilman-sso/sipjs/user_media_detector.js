class UserMediaDetector {
    // Returns info on all user media devices.
    async devices() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
            throw(Error("UserMediaDetector getDevices failed: enumerateDevices is not supported"));
        }

        const mediaDevices = await navigator.mediaDevices.enumerateDevices();

        return mediaDevices.map(
                ({ deviceId, groupId, kind, label }) => ({ deviceId, groupId, kind, label })
                );
    }

    // Returns permitted status of given user media.
    async permitted(kind) {
        if (!kind || !Object.values(UserMediaDetector.Kinds).includes(kind)) {
            throw(Error(`UserMediaDetector permitted failed: kind ${kind} is not supported`));
        }

        const devices = await this.devices();

        // Note: The presence of a `label` on a device indicates that it
        //   the device is active or persistent permissions are granted.
        const permitted = !!devices.find(
                device => device.kind === kind && !!device.label
                );

        return permitted;
    }

    // Returns boolean value designating if all given media kinds are permitted.
    async permittedAll(kinds = Object.values(UserMediaDetector.Kinds)) {
        const kindsArray = Array.isArray(kinds) ? kinds : Array.of(kinds);
        const permissionStates = await Promise.all(kindsArray.map(kind => this.permitted(kind)));

        return permissionStates.every(isPermitted => isPermitted);
    }
}

UserMediaDetector.Kinds = {
    VideoInput: "videoinput",
    AudioInput: "audioinput",
    AudioOutput: "audioinput"
};

//export default UserMediaDetector;
