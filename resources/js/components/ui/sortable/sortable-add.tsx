import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { set } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useState } from "react";
import type { AnonymousItem } from ".";
import type { SelectOption } from "@narsil-cms/types/forms";
import type { UniqueIdentifier } from "@dnd-kit/core";

type SortableAddProps = React.ComponentProps<"div"> & {
  items: AnonymousItem[];
  labelKey: string;
  options: SelectOption[];
  setItems: (items: AnonymousItem[]) => void;
};

function SortableAdd({
  className,
  items,
  labelKey,
  options,
  setItems,
  ...props
}: SortableAddProps) {
  const { getLabel } = useLabels();

  const [value, setValue] = useState<UniqueIdentifier>("");
  const [option, setOption] = useState<SelectOption | undefined>(undefined);

  return (
    <div
      className={cn(
        "flex w-full items-center justify-between gap-3",
        className,
      )}
      {...props}
    >
      <Combobox
        className="w-auto grow"
        options={options.filter(
          (option) => !items.find((item) => item.id == option.value),
        )}
        value={value}
        setValue={(value) => {
          const option = options.find((option) => option.value == value);

          setOption(option);
          setValue(value);
        }}
      />
      <Button
        disabled={!option}
        type="button"
        onClick={() => {
          if (option) {
            const item: AnonymousItem = { id: option.value };

            set(item, labelKey, option.label);

            setItems([...items, item]);

            setOption(undefined);
            setValue("");
          }
        }}
      >
        {getLabel("ui.add")}
      </Button>
    </div>
  );
}

export default SortableAdd;
