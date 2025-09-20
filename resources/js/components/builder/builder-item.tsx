import { FormRenderer } from "@narsil-cms/components/form";
import { SortableItem } from "@narsil-cms/components/sortable";

import { Builder, BuilderNode } from ".";

type BuilderItemProps = Omit<
  React.ComponentProps<typeof SortableItem>,
  "item"
> & {
  baseHandle?: string;
  node: BuilderNode;
};

function BuilderItem({ baseHandle, node, ...props }: BuilderItemProps) {
  return (
    <SortableItem
      className="w-full"
      collapsible={true}
      item={node}
      label={node.block.name}
      {...props}
    >
      {node.block.elements?.map((element, index) => {
        const childElement = element.element;

        const childHandle = element.handle ?? childElement.handle;
        const childName = element.name ?? childElement.name;

        return (
          <FormRenderer
            {...element.element}
            handle={`${baseHandle}.values.${childHandle}`}
            name={childName}
            key={index}
          />
        );
      })}
      {node.block.sets && node.block.sets.length > 0 ? (
        <Builder name={`${baseHandle}.children`} sets={node.block.sets} />
      ) : null}
    </SortableItem>
  );
}

export default BuilderItem;
