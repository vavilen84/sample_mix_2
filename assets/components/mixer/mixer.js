import React from "react";

class Mixer extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            squares: Array(9).fill(null),
        };
        console.log(123);
    }

    render() {
        return (
            <div className="shopping-list">
                <h1>Mixer</h1>
            </div>
        );
    }
}

export default Mixer;