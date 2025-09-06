import * as React from "react";
import { cn, getSelectOption } from "@narsil-cms/lib/utils";
import { CommandItem } from "@narsil-cms/components/ui/command";
import { Icon } from "@narsil-cms/components/ui/icon";
import { isString } from "lodash";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import type { SelectOption } from "@narsil-cms/types/forms";

type ComboboxItemProps = Omit<
  React.ComponentProps<typeof CommandItem>,
  "value"
> & {
  displayValue?: boolean;
  item: SelectOption | string;
  labelPath: string;
  value: string | string[];
  valuePath: string;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function ComboboxItem({
  displayValue,
  item,
  labelPath,
  value,
  valuePath,
  renderOption,
  ...props
}: ComboboxItemProps) {
  const optionLabel = getSelectOption(item, labelPath);
  const optionValue = getSelectOption(item, valuePath);

  const isSelected = Array.isArray(value)
    ? value.includes(optionValue)
    : value === optionValue;

  return (
    <CommandItem {...props} value={optionValue.toString()}>
      <Icon
        className={cn("size-4", isSelected ? "opacity-100" : "opacity-0")}
        name="check"
      />
      {!isString(item) && item.icon ? (
        <Icon className="size-4" name={item.icon} />
      ) : null}
      <div className="flex w-full items-center justify-between gap-2 truncate">
        {renderOption ? (
          renderOption(item)
        ) : (
          <span className="min-w-1/2 grow truncate">{optionLabel}</span>
        )}
        {displayValue && (
          <Tooltip tooltip={optionValue}>
            <span className="text-muted-foreground truncate">
              {optionValue}
            </span>
          </Tooltip>
        )}
      </div>
    </CommandItem>
  );
}

export default ComboboxItem;
