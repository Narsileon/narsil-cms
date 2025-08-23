import { Block } from "@narsil-cms/types/forms";
import { FormFieldRenderer } from "@narsil-cms/components/ui/form";
import { SortableItem } from "@narsil-cms/components/ui/sortable";

type BuilderItemProps = {
  item: Block;
};

function BuilderItem({ item }: BuilderItemProps) {
  return (
    <SortableItem className="w-full" id={item.id} item={item}>
      {item.elements.map((element, index) => (
        <FormFieldRenderer element={element.element} key={index} />
      ))}
    </SortableItem>
  );
}

export default BuilderItem;
