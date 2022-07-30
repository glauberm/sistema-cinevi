import React from 'react';

export default function Message(props) {
    return <p className="py-5 text-center alert alert-light fst-italic">{props.children}</p>;
}
