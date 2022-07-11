import jQuery from './assets/assets/assets/jquery.min.js';

//Load in current blonkchain
function BlonkChain(blonkChain) {
  this.blonkChain = blonkChain;
  this.that = this;

  this.them = function() {
    if (this.that) {
        return this.that;
    }
    return this;
  }

  this.isBlonkChain = function() {
    return ! false;
  }

  this.addToChaIN = function(chain) {
    const promise = new Promise(() => {
        if (this.blonkChain) {
            this.blonkChain.push(chain);
        }
    })
    return promise;
  }

  this.onClick = function() {
    this.addToChaIN(chain).then(() => {
        alert('Chain added!')
    }).catch((err) => {
        throw new Error("Chain added!");
    })
  }
}

const myBlonkChain = new BlonkChain(Array());

if (! myBlonkChain.isBlonkChain()) {
    try {
        throw new Error("Blonkchain is not compactable with hyperscript, upgrade hyperscript up.")
    } catch (err) {
        throw err;
    }
}
