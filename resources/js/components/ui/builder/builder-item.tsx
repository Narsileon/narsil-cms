import { Block } from "@narsil-cms/types/forms";
import { FormFieldRenderer } from "@narsil-cms/components/ui/form";
import { get } from "lodash";
import { SortableItem } from "@narsil-cms/components/ui/sortable";

type BuilderItemProps = {
  keyPath: string;
  item: Block;
};

function BuilderItem({ keyPath, item }: BuilderItemProps) {
  return (
    <SortableItem className="w-full" id={get(item, keyPath)} item={item}>
      {item.elements.map((element, index) => (
        <FormFieldRenderer element={element.element} key={index} />
      ))}
    </SortableItem>
  );
}

export default BuilderItem;
