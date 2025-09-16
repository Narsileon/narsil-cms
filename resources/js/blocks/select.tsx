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

type SelectOption =
  | string
  | {
      label: string;
      value: string;
    };

type SelectProps = React.ComponentProps<typeof SelectRoot> & {
  contentProps?: Partial<React.ComponentProps<typeof SelectContent>>;
  iconProps?: Partial<React.ComponentProps<typeof SelectIcon>>;
  itemProps?: Partial<React.ComponentProps<typeof SelectItem>>;
  itemIndicatorProps?: Partial<
    React.ComponentProps<typeof SelectItemIndicator>
  >;
  itemTextProps?: Partial<React.ComponentProps<typeof SelectItemText>>;
  options?: SelectOption[];
  portalProps?: Partial<React.ComponentProps<typeof SelectPortal>>;
  scrollDownButtonProps?: Partial<
    React.ComponentProps<typeof SelectScrollDownButton>
  >;
  scrollUpButtonProps?: Partial<
    React.ComponentProps<typeof SelectScrollUpButton>
  >;
  triggerProps?: Partial<React.ComponentProps<typeof SelectTrigger>>;
  valueProps?: Partial<React.ComponentProps<typeof SelectValue>>;
  viewportProps?: Partial<React.ComponentProps<typeof SelectViewport>>;
};

const Select = ({
  children,
  contentProps,
  iconProps,
  itemIndicatorProps,
  itemProps,
  itemTextProps,
  options,
  portalProps,
  scrollDownButtonProps,
  scrollUpButtonProps,
  triggerProps,
  valueProps,
  viewportProps,
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
      <SelectTrigger {...triggerProps}>
        <SelectValue {...valueProps} />
        <SelectIcon {...iconProps} />
      </SelectTrigger>
      <SelectPortal {...portalProps}>
        <SelectContent {...contentProps}>
          <SelectScrollUpButton {...scrollUpButtonProps} />
          <SelectViewport {...viewportProps}>
            {children}
            {options?.map((option, index) => (
              <SelectItem
                {...itemProps}
                value={getOptionValue(option)}
                key={index}
              >
                <SelectItemText {...itemTextProps}>
                  {getOptionLabel(option)}
                </SelectItemText>
                <SelectItemIndicator {...itemIndicatorProps} />
              </SelectItem>
            ))}
          </SelectViewport>
          <SelectScrollDownButton {...scrollDownButtonProps} />
        </SelectContent>
      </SelectPortal>
    </SelectRoot>
  );
};

export default Select;
