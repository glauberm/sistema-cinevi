import React from 'react';

export default function Message(props) {
    return <p className="p-5 m-5 text-center text-muted">{props.children}</p>;
}
