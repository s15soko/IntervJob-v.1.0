import * as React from "react";

export class ExcelResult extends React.Component
{
    render()
    {
        var data = this.props.data;
        var tdElements = [];
        var counter = 0;
        
        data.forEach(tdRow => {
            tdElements.push(<td key={counter}>{tdRow}</td>)
            counter++;
        });

        return (
            <tr>
                {tdElements}
            </tr>
        );
    }
}