import {
  CheckboxIndicator,
  CheckboxRoot,
} from "@narsil-cms/components/checkbox";
import { Icon } from "@narsil-cms/components/icon";

type CheckboxProps = React.ComponentProps<typeof CheckboxRoot> & {};

function Checkbox({ ...props }: CheckboxProps) {
  return (
    <CheckboxRoot {...props}>
      <CheckboxIndicator>
        <Icon className="size-3.5" name="check" />
      </CheckboxIndicator>
    </CheckboxRoot>
  );
}

export default Checkbox;
