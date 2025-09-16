import {
  CheckboxIndicator,
  CheckboxRoot,
} from "@narsil-cms/components/checkbox";
import { Icon } from "@narsil-cms/components/icon";
import { type IconName } from "@narsil-cms/plugins/icons";

type CheckboxProps = React.ComponentProps<typeof CheckboxRoot> & {
  icon?: IconName;
  indicatorProps?: Partial<React.ComponentProps<typeof CheckboxIndicator>>;
};

function Checkbox({ icon = "check", indicatorProps, ...props }: CheckboxProps) {
  return (
    <CheckboxRoot {...props}>
      <CheckboxIndicator {...indicatorProps}>
        <Icon className="size-3.5" name={icon} />
      </CheckboxIndicator>
    </CheckboxRoot>
  );
}

export default Checkbox;
