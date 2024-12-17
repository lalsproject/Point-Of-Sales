<?php $this->section("styles") ?>
<style>
    .calculator {
        display: grid;
        grid-template-rows: repeat(7, minmax(60px, auto));
        grid-template-columns: repeat(4, 60px);
        grid-gap: 12px;
        padding: 35px;
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        font-size: 18px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 3px 80px -30px rgba(13, 81, 134, 1);
    }

    .btn,
    .zero {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        outline: none;
        color: #484848;
        background-color: #f4faff;
        border-radius: 5px;
        font-weight: 400;
    }

    .display,
    .answer {
        grid-column: 1 / 5;
        display: flex;
        align-items: center;
    }

    .display {
        color: #212121;
        border-bottom: 1px solid #e1e1e1;
        margin-bottom: 15px;
        overflow: hidden;
        text-overflow: clip;
    }

    .answer {
        font-weight: 500;
        color: #146080;
        font-size: 55px;
        height: 65px;
    }

    .zero {
        grid-column: 1 / 3;
    }

    .operator {
        background-color: #d9efff;
        color: #3fa9fc;
        font-weight: 500;
    }
</style>
<?php $this->endSection("styles") ?>

<v-dialog v-model="modalCalculator" width="350">
    <v-card>
        <v-card-title class="text-h5 grey lighten-2">
            Calculator
            <v-spacer></v-spacer>
            <v-btn icon @click="modalCalculatorClose">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-card-title>
        <div class="calculator">
            <div class="answer overflow-x-auto overflow-y-hidden">{{ answer }}</div>
            <div class="display">{{ logList + current }}</div>
            <div @click="clear" id="clear" class="btn operator">C</div>
            <div @click="sign" id="sign" class="btn operator">+/-</div>
            <div @click="percent" id="percent" class="btn operator">
                %
            </div>
            <div @click="divide" id="divide" class="btn operator">
                /
            </div>
            <div @click="append('7')" id="n7" class="btn">7</div>
            <div @click="append('8')" id="n8" class="btn">8</div>
            <div @click="append('9')" id="n9" class="btn">9</div>
            <div @click="times" id="times" class="btn operator">*</div>
            <div @click="append('4')" id="n4" class="btn">4</div>
            <div @click="append('5')" id="n5" class="btn">5</div>
            <div @click="append('6')" id="n6" class="btn">6</div>
            <div @click="minus" id="minus" class="btn operator">-</div>
            <div @click="append('1')" id="n1" class="btn">1</div>
            <div @click="append('2')" id="n2" class="btn">2</div>
            <div @click="append('3')" id="n3" class="btn">3</div>
            <div @click="plus" id="plus" class="btn operator">+</div>
            <div @click="append('0')" id="n0" class="zero">0</div>
            <div @click="dot" id="dot" class="btn">.</div>
            <div @click="equal" id="equal" class="btn operator">=</div>
        </div>
    </v-card>
</v-dialog>

<?php $this->section("js") ?>
<script>
    // Initial Data
    dataVue = {
        ...dataVue,
        modalCalculator: false,
        logList: "",
        current: 0,
        answer: "",
        operatorClicked: true
    }

    createdVue = function() {

    }

    // Vue Methods
    // Methods: Metode-metode yang kemudian digabung ke dalam Vue instance
    methodsVue = {
        ...methodsVue,
        modalCalculatorClose: function() {
            this.modalCalculator = false;
            this.getKeranjang();
        },
        append(number) {
            if (this.operatorClicked) {
                this.current = "";
                this.operatorClicked = false;
            }
            this.animateNumber(`n${number}`);
            this.current = `${this.current}${number}`;
        },
        addtoLog(operator) {
            if (this.operatorClicked == false) {
                this.logList += `${this.current} ${operator} `;
                this.current = "";
                this.operatorClicked = true;
            }
        },
        animateNumber(number) {
            let tl = anime.timeline({
                targets: `#${number}`,
                duration: 250,
                easing: "easeInOutCubic"
            });
            tl.add({
                backgroundColor: "#c1e3ff"
            });
            tl.add({
                backgroundColor: "#f4faff"
            });
        },
        animateOperator(operator) {
            let tl = anime.timeline({
                targets: `#${operator}`,
                duration: 250,
                easing: "easeInOutCubic"
            });
            tl.add({
                backgroundColor: "#a6daff"
            });
            tl.add({
                backgroundColor: "#d9efff"
            });
        },
        clear() {
            this.animateOperator("clear");
            this.current = "";
            this.answer = "";
            this.logList = "";
            this.operatorClicked = false;
        },
        sign() {
            this.animateOperator("sign");
            if (this.current != "") {
                this.current =
                    this.current.charAt(0) === "-" ?
                    this.current.slice(1) :
                    `-${this.current}`;
            }
        },
        percent() {
            this.animateOperator("percent");
            if (this.current != "") {
                this.current = `${parseFloat(this.current) / 100}`;
            }
        },
        dot() {
            this.animateNumber("dot");
            if (this.current.indexOf(".") === -1) {
                this.append(".");
            }
        },
        divide() {
            this.animateOperator("divide");
            this.addtoLog("/");
        },
        times() {
            this.animateOperator("times");
            this.addtoLog("*");
        },
        minus() {
            this.animateOperator("minus");
            this.addtoLog("-");
        },
        plus() {
            this.animateOperator("plus");
            this.addtoLog("+");
        },
        equal() {
            this.animateOperator("equal");
            if (this.operatorClicked == false) {
                this.answer = eval(this.logList + this.current);
            } else {
                this.answer = "?";
            }
        }
    }
</script>
<?php $this->endSection("js") ?>