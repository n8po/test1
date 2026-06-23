import sys
sys.stdout.reconfigure(encoding='utf-8')
from docx import Document
from lxml import etree

DOCX = r'C:\Project\latihan\lsp_ukm\test1\RadityaNathaAzra_TUKTI_23_updated.docx'
doc = Document(DOCX)
body = doc.element.body
W = '{http://schemas.openxmlformats.org/wordprocessingml/2006/main}'

# Collect BlatUI content elements (between heading and Use Case)
blat_els = []
found_heading = False
for child in list(body):
    if child.tag != W + 'p':
        continue
    texts = child.findall('.//' + W + 't')
    txt = ''.join(t.text or '' for t in texts)
    
    # Check if this is the BlatUI heading
    ppr = child.find(W + 'pPr')
    pStyle = None
    if ppr is not None:
        ps_el = ppr.find(W + 'pStyle')
        if ps_el is not None:
            pStyle = ps_el.get(W + 'val')
    
    if pStyle and 'Heading' in pStyle and 'BLATUI' in txt:
        found_heading = True
        continue
    
    if found_heading:
        if 'USE CASE' in txt and pStyle and 'Heading' in pStyle:
            break
        blat_els.append(child)

print(f'Found {len(blat_els)} BlatUI content elements')

if not blat_els:
    print("No elements found!")
else:
    # Remove all from body
    for el in blat_els:
        body.remove(el)
    
    # Find BlatUI heading again
    blat_h = None
    for child in list(body):
        if child.tag != W + 'p':
            continue
        texts = child.findall('.//' + W + 't')
        txt = ''.join(t.text or '' for t in texts)
        ppr = child.find(W + 'pPr')
        if ppr is not None:
            ps_el = ppr.find(W + 'pStyle')
            if ps_el is not None and 'Heading' in (ps_el.get(W + 'val') or '') and 'BLATUI' in txt:
                blat_h = child
                break
    
    print(f'BlatUI heading found: {blat_h is not None}')
    
    if blat_h:
        # Insert content in correct order (blat_els was collected in forward order)
        # We need to insert them after heading in forward order
        # Since we remove from body then re-insert after heading
        # Insert in reverse so they end up in forward order
        for el in reversed(blat_els):
            body.insert(list(body).index(blat_h) + 1, el)
        
        print('Inserted in correct order')
    
    doc.save(DOCX)
    print('SAVED!')
