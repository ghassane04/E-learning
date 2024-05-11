<div id="main-container">
        <div class="content-box">
            <div class="preview">
                <div class="card">
                    <div class="front">
                        <div class="title">CREDIT CARD</div>
                        <div id="chip">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                        <div class="card-number">0000 0000 0000 0000</div>
                        <div class="card-name">Name Surname</div>
                        <div class="validity-box">
                            <span>
                                <p>VALID</p>
                                <p>THRU</p>
                            </span>
                            <span>►</span><span class="card-validity">00/00</span>
                        </div>
                        <div class="logo">MasterCard</div>
                    </div>

                    <div class="back">
                        <div class="top-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                        <div class="strip"></div>
                        <div class="box">
                            <div class="signature"></div>
                            <div class="card-cvv">000</div>
                        </div>
                        <div class="text">
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid perferendis illum vero,
                                porro totam iure cupiditate ipsum placeat nihil, quibusdam architecto beatae atque ipsam
                                corrupti laudantium? Vel cupiditate laborum id, perspiciatis cumque, eaque inventore
                                molestiae eos a, officia maxime nihil mollitia aut hic quia provident!</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error quod accusamus delectus
                                eius rerum cum officiis quisquam impedit placeat temporibus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <form>
                <div class="field">
                    <label for="number">Card Number</label>
                    <input type="text" id="number" oninput="UpdateAccountNumber(this);" maxlength="19">
                </div>

                <div class="field">
                    <label for="name">Card Holder</label>
                    <input type="text" id="name" oninput="updateCardHolder(this);" maxlength="25">
                </div>

                <div class="field">
                    <label for="validity">Valid upto (MM/YY)</label>
                    <input type="text" id="validity" oninput="updateValidity(this)" maxlength="5">
                </div>

                <div class="field">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" oninput="updateCardCvv(this)" maxlength="3">
                </div>

            </form>
        </div>
    </div>