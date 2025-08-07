import { SortableItem } from "@narsil-cms/components/ui/sortable";
import {
  horizontalListSortingStrategy,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import type { AnonymousItem } from ".";
import type {
  Field,
  FormType,
  GroupedSelectOption,
  SelectOption,
} from "@narsil-cms/types/forms";

type SortableListContextProps = {
  direction?: "horizontal" | "vertical";
  form?: FormType;
  items: AnonymousItem[];
  options: GroupedSelectOption[];
  unique?: boolean;
  widthOptions?: SelectOption[];
  setItems: (items: AnonymousItem[]) => void;
};

function SortableListContext({
  direction = "vertical",
  form,
  items,
  options,
  unique,
  widthOptions,
  setItems,
}: SortableListContextProps) {
  function getGroup(item: AnonymousItem) {
    const group = options.find((x) =>
      item.identifier.includes(x.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getFormattedLabel(item: AnonymousItem) {
    const group = getGroup(item);

    const label = item[group.optionLabel];
    const value = item[group.optionValue];

    return unique ? label : `${label} (${value})`;
  }

  function getUniqueIdentifier(item: AnonymousItem) {
    const group = getGroup(item);

    return item[group.optionValue];
  }

  return (
    <SortableContext
      items={items.map((item) => getUniqueIdentifier(item))}
      strategy={
        direction === "vertical"
          ? verticalListSortingStrategy
          : horizontalListSortingStrategy
      }
    >
      <ul className="grid gap-2">
        {items.map((item) => {
          const id = getUniqueIdentifier(item);
          const label = getFormattedLabel(item);

          return (
            <SortableItem
              id={id}
              form={form}
              group={getGroup(item)}
              item={item}
              label={label}
              widthOptions={widthOptions}
              onItemChange={(value: AnonymousItem) => {
                setItems(
                  items.map((x) => (getUniqueIdentifier(x) === id ? value : x)),
                );
              }}
              onItemRemove={() => {
                setItems(items.filter((x) => x !== item));
              }}
              key={id}
            />
          );
        })}
      </ul>
    </SortableContext>
  );
}

export default SortableListContext;
