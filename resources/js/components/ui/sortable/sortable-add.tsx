import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { ModalLink } from "@narsil-cms/components/ui/modal";
import { set } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import type { AnonymousItem } from ".";
import type { SelectOption } from "@narsil-cms/types/forms";

type SortableAddProps = React.ComponentProps<"div"> & {
  href: string;
  items: AnonymousItem[];
  label: string;
  labelKey: string;
  options: SelectOption[];
  setItems: (items: AnonymousItem[]) => void;
};

function SortableAdd({
  className,
  href,
  items,
  label,
  labelKey,
  options,
  setItems,
  ...props
}: SortableAddProps) {
  const { getLabel } = useLabels();

  const filteredOptions = options.filter(
    (option) => !items.find((item) => item.id == option.value),
  );

  return (
    <div
      className={cn(
        "grid w-full grid-cols-4 items-center justify-between gap-6 text-sm",
        className,
      )}
      {...props}
    >
      <span className="text-left">{label}</span>
      <Combobox
        className="col-span-2 grow"
        disabled={filteredOptions.length == 0}
        placeholder={getLabel("placeholders.choose")}
        options={filteredOptions}
        value={""}
        setValue={(value) => {
          const option = options.find((option) => option.value == value);

          if (!option) {
            return;
          }

          const item = { id: option.value };

          set(item, labelKey, option.label);

          setItems([...items, item]);
        }}
      />
      <Button className="justify-self-end" type="button" asChild={true}>
        <ModalLink href={href}>{getLabel("ui.create")}</ModalLink>
      </Button>
    </div>
  );
}

export default SortableAdd;
