import * as React from "react";
import { Icon } from "@narsil-cms/components/ui/icon";
import Input from "./input";

type InputPasswordProps = Omit<
  React.ComponentProps<typeof Input>,
  "children"
> & {};

function InputPassword({ type, ...props }: InputPasswordProps) {
  const [show, setShow] = React.useState(false);

  return (
    <Input type={show ? "text" : type} {...props}>
      <Icon
        className="opacity-50"
        name={show ? "eye-off" : "eye"}
        onClick={() => setShow(!show)}
      />
    </Input>
  );
}

export default InputPassword;
