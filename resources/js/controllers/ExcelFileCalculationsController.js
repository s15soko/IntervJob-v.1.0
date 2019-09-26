import * as React from "react";
import * as ReactDOM from "react-dom";
import { ExcelTableHeader } from "../components/ExcelTableHeader";
import { ExcelResult } from "../components/ExcelResult";

export class ExcelFileCalculationsController
{
    constructor()
    {
        this.partyNumberValue = 0;
    }
    
    init()
    {
        this.events();
    }

    /**
     * Count data and prepare elements to build
     */
    startCounting()
    {
        var tableElements = $("#tableExcelContent").find("tr");
        var list = [];

        var maxTDCounter = 4; // get first X rows from tr
        var multiplier = this.partyNumberValue;

        var header = true;
        Object.keys(tableElements).forEach(trKey => {
            
            // Table header
            if(header == true){
                header = false;
                list.push(<ExcelTableHeader key="header"/>);
                
            }
            else{
                
                var TRElements = $(tableElements[trKey]).find("td");
                var counter = 0;
                var data = [];

                Object.keys(TRElements).forEach(tdKey => {
                    var lpKey = $(TRElements[0]).text();
                    // skip if not a number 
                    if(!Number.isInteger(Number(lpKey)) || lpKey == "")
                        return;

                    if(counter <= maxTDCounter){
                        if(counter > 1 && counter < 5){
                            var tdValue = Number($(TRElements[tdKey]).text());
                            tdValue *= multiplier;
                        }else{
                            var tdValue = String($(TRElements[tdKey]).text());
                        }
                            
                        data.push(tdValue);
                    }
                    
                    counter++;
                });
                
                list.push(<ExcelResult key={data[0]} data={data}/>);
            }
            
        });

        this.buildResultView(list);
    }

    /**
     * Show counted data
     * 
     * @param {object} list 
     */
    buildResultView(list)
    {
        if(document.getElementById("calculationsResultContainer"))
        {
            ReactDOM.render((
                <div>
                    <table>
                        <tbody>
                            {list}
                        </tbody>
                    </table>
                </div>
            ), document.getElementById("calculationsResultContainer"));
        }
    }

    updateEventsValue()
    {
        var inputPartyNumberValue = $("#partyNumber").val();
        
        inputPartyNumberValue == ""
            ? 0 : inputPartyNumberValue;
        
        this.partyNumberValue = inputPartyNumberValue;
    }

    events()
    {
        var management = this;

        $(document).on("click", "#calculateButton", () => {
            management.updateEventsValue();
            management.startCounting();
        })
    }
}