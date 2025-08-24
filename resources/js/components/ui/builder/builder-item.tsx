import { Block } from "@narsil-cms/types/forms";
import { FormFieldRenderer } from "@narsil-cms/components/ui/form";
import { SortableItem } from "@narsil-cms/components/ui/sortable";
import React from "react";

type BuilderItemProps = Omit<
  React.ComponentProps<typeof SortableItem>,
  "item"
> & {
  handle?: string;
  item: Block;
};

function BuilderItem({ handle, item, ...props }: BuilderItemProps) {
  return (
    <SortableItem
      className="w-full"
      collapsible={true}
      item={item}
      label={item.name}
      {...props}
    >
      {item.elements.map((element, index) => (
        <FormFieldRenderer
          element={element.element}
          handle={handle}
          key={index}
        />
      ))}
    </SortableItem>
  );
}

export default BuilderItem;
