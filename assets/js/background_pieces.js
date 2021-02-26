/* $(document).ready(function() {
    var uprightPiece = document.getElementById("piece-upright");
    var sidewaysPiece = document.getElementById("piece-sideways");
    var doc = document.getElementById("background");
    var activePieces = new Array();
    var newActive = new Array();
    var toBeDeleted = new Array();
    var counter = 0;

    window.setInterval(function(){
        if (activePieces.length == 0) {
            var newPiece = new BackgroundPiece(true, Math.floor(Math.random()*950),Math.floor(Math.random()*1820), Math.floor(Math.random())*4,counter);
            counter++;
            newPiece.display();
            activePieces.push(newPiece);
        } else {
            for (var i = 0; i < activePieces.length; i++) {
                
                var breed = activePieces[i].breed();
                var orientation = activePieces[i].getOrient();
                if (newActive.length < 4) {
                    if (orientation) {
                        if (breed & 1) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()+15,activePieces[i].getLeft()+34, 1,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 2) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()+15,activePieces[i].getLeft()-64, 2,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 4) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()+64,activePieces[i].getLeft()-15, 3,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 8) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()-34,activePieces[i].getLeft()-15, 4,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                    } else {
                        if (breed & 1) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()-15,activePieces[i].getLeft()+64, 1,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 2) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()-15,activePieces[i].getLeft()-34, 2,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 4) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()+34,activePieces[i].getLeft()+15, 3,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                        if (breed & 8) {
                            var newPiece = new BackgroundPiece(!orientation, activePieces[i].getTop()-64,activePieces[i].getLeft()+15, 4,counter);
                            newPiece.display();
                            newActive.push(newPiece);
                            counter++;
                        }
                    }
                }
                toBeDeleted.push(activePieces[i]);
            }

            activePieces = Array.from(newActive);
            newActive = new Array();

            for (var i = 0; i < toBeDeleted.length; i++) {
                var faded = toBeDeleted[i].fade();
                document.getElementById(toBeDeleted[i].getID()).classList.add("hide-piece");
                if (faded) {
                    var deletedPiece = document.getElementById(toBeDeleted[i].getID());
                    deletedPiece.parentNode.removeChild(deletedPiece);
                    toBeDeleted.splice(i,1);
                }
                
            }
        }
    }, 2000);



    
    class BackgroundPiece {
        
        constructor(upright, top, left, loc, id) {
            this.upright=upright;
            this.top=top;
            this.left=left;
            this.loc = loc;
            this.fadeCounter = 3;
            this.id = id;
            if (upright) {
                this.pieceClone = uprightPiece.cloneNode(true);
            } else {
                this.pieceClone = sidewaysPiece.cloneNode(true);
            }
            this.pieceClone.id = id;
            this.pieceClone.style.top = this.top;
            this.pieceClone.style.left = this.left;
        }
        getTop() {
            return this.top;
        }
        getLeft() {
            return this.left;
        }
        display() {
            doc.appendChild(this.pieceClone);
            this.pieceClone.classList.add("show-piece");
        }
        breed() {
            var total = 0;
            if (this.loc != 2 && Math.floor(Math.random()*3) <= 1 && this.left <=1800) {
                total += 1;
            }
            if (this.loc != 1 && Math.floor(Math.random()*3) <= 1 && this.left >= -50) {
                total += 2;
            }
            if (this.loc != 4 && Math.floor(Math.random()*3) <= 1 && this.top <= 1000) {
                total += 4;
            }
            if (this.loc != 3 && Math.floor(Math.random()*3) <= 1 && this.top >= -50) {
                total += 8;
            }
            return total;
        }
        getOrient() {
            return this.upright;
        }
        fade() {
            this.fadeCounter --;
            if (this.fadeCounter == 0) {
                return true;
            } else {
                return false;
            }
        }
        getID() {
            return this.id.toString();
        }
    }
});
 */