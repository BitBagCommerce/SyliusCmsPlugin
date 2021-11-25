const triggerCustomEvent = (node, eventName, data) => {
    const eventPrefix = 'bb';
    const customEvent = new CustomEvent(`${eventPrefix}.${eventName}`, {detail: data});

    node.dispatchEvent(customEvent);

    return node;
};

export default triggerCustomEvent;
