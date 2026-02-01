import { Icon } from "@narsil-cms/blocks/icon";
import { InputContent } from "@narsil-cms/components/input";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@narsil-cms/components/input-group";
import { useLocalization } from "@narsil-cms/components/localization";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { useState, type ComponentProps } from "react";

type PasswordProps = Omit<ComponentProps<typeof InputContent>, "children">;

function Password({ type, ...props }: PasswordProps) {
  const { trans } = useLocalization();

  const [show, setShow] = useState(false);

  const tooltip = show
    ? trans("accessibility.hide_password")
    : trans("accessibility.show_password");

  return (
    <InputGroup>
      <InputGroupInput {...props} type={show ? "text" : type} />
      <InputGroupAddon align="inline-end">
        <Tooltip tooltip={tooltip}>
          <Icon
            className="cursor-pointer opacity-50 duration-300 hover:opacity-100"
            aria-label={tooltip}
            name={show ? "eye-off" : "eye"}
            onClick={() => setShow(!show)}
          />
        </Tooltip>
      </InputGroupAddon>
    </InputGroup>
  );
}

export default Password;
