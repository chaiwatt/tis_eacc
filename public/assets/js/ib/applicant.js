

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
    
        // ใช้ innerText โดยไม่ลบ newline
        let text = this.editableDiv.innerText;
        tempDiv.textContent = text;
        document.body.appendChild(tempDiv);
    
        const lines = [];
        const range = document.createRange();
        let currentLine = '';
        let lastTop = null;
    
        // แยกข้อความตาม newline ก่อน
        const textLines = text.split('\n');
    
        for (let line of textLines) {
            if (line.trim() === '') {
                // ถ้าเป็นบรรทัดว่างจาก newline ให้เพิ่มเข้าไป
                lines.push('');
                continue;
            }
    
            // ใส่ข้อความของบรรทัดนี้เข้า tempDiv เพื่อเช็คการตัดตามความกว้าง
            tempDiv.textContent = line;
    
            let subCurrentLine = '';
            for (let i = 0; i < line.length; i++) {
                range.setStart(tempDiv.firstChild, i);
                range.setEnd(tempDiv.firstChild, i + 1);
                const rect = range.getClientRects()[0];
    
                if (rect) {
                    if (lastTop !== null && rect.top !== lastTop) {
                        lines.push(subCurrentLine.trim());
                        subCurrentLine = line[i];
                    } else {
                        subCurrentLine += line[i];
                    }
                    lastTop = rect.top;
                }
    
                if (i === line.length - 1) {
                    lines.push(subCurrentLine.trim());
                }
            }
            lastTop = null; // รีเซ็ต lastTop สำหรับบรรทัดถัดไป
        }
    
        document.body.removeChild(tempDiv);
    
        return lines;
    }

}

