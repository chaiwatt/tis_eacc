// custom/line_extractor/line-extractor.js
class LineExtractor {
    constructor(elementId) {
        this.editableDiv = document.getElementById(elementId);
        this.init();
    }

    init() {
        if (!this.editableDiv) {
            console.error('Element not found');
            return;
        }

        // เพิ่ม event listener สำหรับ paste เพื่อแปลงเป็น plaintext
        this.editableDiv.addEventListener('paste', (event) => {
            // ป้องกันการ paste แบบปกติ (ที่มี style)
            event.preventDefault();

            // ดึงข้อความแบบ plaintext
            const text = (event.clipboardData || window.clipboardData).getData('text/plain');

            // ใช้ Selection และ Range เพื่อแทรกข้อความ
            const selection = window.getSelection();
            if (selection.rangeCount) {
                const range = selection.getRangeAt(0);
                range.deleteContents();

                const textNode = document.createTextNode(text);
                range.insertNode(textNode);

                // ย้าย caret ไปหลังข้อความที่แทรก
                range.setStartAfter(textNode);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        });
    }

    getLines() {
        const tempDiv = document.createElement('div');
        tempDiv.style.width = window.getComputedStyle(this.editableDiv).width;
        tempDiv.style.position = 'absolute';
        tempDiv.style.visibility = 'hidden';
        tempDiv.style.whiteSpace = 'pre-wrap';
        tempDiv.style.overflowWrap = 'break-word';
        tempDiv.style.fontFamily = window.getComputedStyle(this.editableDiv).fontFamily;
        tempDiv.style.fontSize = window.getComputedStyle(this.editableDiv).fontSize;

        let text = this.editableDiv.innerText.replace(/\n/g, '');
        tempDiv.textContent = text;
        document.body.appendChild(tempDiv);

        const lines = [];
        const range = document.createRange();
        let currentLine = '';
        let lastTop = null;

        for (let i = 0; i < text.length; i++) {
            range.setStart(tempDiv.firstChild, i);
            range.setEnd(tempDiv.firstChild, i + 1);
            const rect = range.getClientRects()[0];

            if (rect) {
                if (lastTop !== null && rect.top !== lastTop) {
                    lines.push(currentLine.trim());
                    currentLine = text[i];
                } else {
                    currentLine += text[i];
                }
                lastTop = rect.top;
            }

            if (i === text.length - 1) {
                lines.push(currentLine.trim());
            }
        }

        document.body.removeChild(tempDiv);

        return lines;
    }
}

if (typeof module !== 'undefined' && module.exports) {
    module.exports = LineExtractor;
}