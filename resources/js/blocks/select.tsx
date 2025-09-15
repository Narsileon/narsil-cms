import { get, isString } from "lodash";

import {
  SelectContent,
  SelectIcon,
  SelectItem,
  SelectItemIndicator,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectScrollDownButton,
  SelectScrollUpButton,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from "@narsil-cms/components/select";
import { IconName } from "@narsil-cms/plugins/icons";

type SelectOption =
  | string
  | {
      label: string;
      value: string;
    };

type SelectProps = React.ComponentProps<typeof SelectRoot> & {
  className?: string;
  options?: SelectOption[];
  valueIcon?: IconName;
};

const Select = ({
  children,
  className,
  valueIcon,
  options,
  ...props
}: SelectProps) => {
  function getOptionLabel(option: SelectOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "label");
  }

  function getOptionValue(option: SelectOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "value");
  }

  return (
    <SelectRoot {...props}>
      <SelectTrigger className={className}>
        <SelectValue />
        <SelectIcon icon={valueIcon} />
      </SelectTrigger>
      <SelectPortal>
        <SelectContent>
          <SelectScrollUpButton />
          <SelectViewport>
            {children}
            {options?.map((option, index) => (
              <SelectItem value={getOptionValue(option)} key={index}>
                <SelectItemText>{getOptionLabel(option)}</SelectItemText>
                <SelectItemIndicator />
              </SelectItem>
            ))}
          </SelectViewport>
          <SelectScrollDownButton />
        </SelectContent>
      </SelectPortal>
    </SelectRoot>
  );
};

export default Select;
